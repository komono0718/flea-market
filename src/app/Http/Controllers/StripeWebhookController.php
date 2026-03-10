<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;

class StripeWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        } catch (\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        }

        $sessionId = $event->data->object->id ?? null;
        if (!$sessionId) return response('No session id', 200);

        $purchase = Purchase::where('stripe_session_id', $sessionId)->first();
        if (!$purchase) return response('Purchase not found', 200);

        if ($event->type === 'checkout.session.completed') {
            $pmTypes = $event->data->object->payment_method_types ?? [];
            $pi = $event->data->object->payment_intent ?? null;

            if ($pi) $purchase->stripe_payment_intent = $pi;

            // cardは即paidでOK
            if (in_array('card', $pmTypes, true)) {
                $purchase->status = 'paid';
                $purchase->paid_at = now();
            }
            $purchase->save();
        }

        // konbini等の非同期成功
        if ($event->type === 'checkout.session.async_payment_succeeded') {
            $purchase->status = 'paid';
            $purchase->paid_at = now();
            $purchase->save();
        }

        // 失敗
        if ($event->type === 'checkout.session.async_payment_failed') {
            $purchase->status = 'canceled';
            $purchase->save();
        }

        return response('ok', 200);
    }
}
