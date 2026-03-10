<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session as CheckoutSession;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{
    // 購入画面
    public function index(Item $item)
    {
        $item->load('purchase');

        if ($item->purchase) {
            return redirect("/item/{$item->id}")->with('error', 'この商品は売り切れです');
        }

        $user = auth()->user();

        $shipping = session("purchase_shipping_{$item->id}", [
            'postcode' => $user->postcode,
            'address'     => $user->address,
            'building'    => $user->building,
        ]);

        $payment_method = session("purchase_payment_method_{$item->id}", 'コンビニ支払い');

        return view('purchase.index', compact('item', 'shipping', 'payment_method'));
    }

    // 支払い方法更新
    public function updatePayment(Request $request, Item $item)
    {
        $request->validate([
            'payment_method' => ['required', 'in:コンビニ支払い,カード支払い'],
        ]);

        session(["purchase_payment_method_{$item->id}" => $request->payment_method]);

        return redirect("/purchase/{$item->id}");
    }

    // 住所変更画面
    public function editAddress(Item $item)
    {
        $user = auth()->user();

        $shipping = session("purchase_shipping_{$item->id}", [
            'postcode' => $user->postcode,
            'address'     => $user->address,
            'building'    => $user->building,
        ]);

        return view('purchase.address', compact('item', 'shipping'));
    }

    // 住所更新（購入画面に反映）
    public function updateAddress(AddressRequest $request, Item $item)
    {
        $data = $request->validated();

        session()->put("purchase_shipping_{$item->id}", $data);

        return redirect()->route('purchase.index', $item);
    }
    // Stripe Checkoutへ
    public function checkout(Item $item)
    {
        $item->load('purchase');
        $user = auth()->user();

        if ($item->user_id === $user->id) {
            return back()->with('error', '自分の商品は購入できません');
        }

        if ($item->purchase) {
            return back()->with('error', 'この商品は売り切れです');
        }

        $payment_method = session("purchase_payment_method_{$item->id}", 'コンビニ支払い');

        $shipping = session("purchase_shipping_{$item->id}", [
            'postcode' => $user->postcode,
            'address'     => $user->address,
            'building'    => $user->building,
        ]);

        if (empty($shipping['postcode']) || empty($shipping['address'])) {
            return redirect("/purchase/{$item->id}/address")->with('error', '配送先住所を入力してください');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $types = ($payment_method === 'カード支払い') ? ['card'] : ['konbini'];

        // pending作成（この時点ではSOLDにしない）
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postcode' => $shipping['postcode'],
            'address' => $shipping['address'],
            'building' => $shipping['building'],
            'payment_method' => $payment_method,
            'status' => 'pending',
        ]);

        $session = CheckoutSession::create([
            'mode' => 'payment',
            'payment_method_types' => $types,
            'customer_email' => $user->email,
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'currency' => 'jpy',
                    'unit_amount' => (int)$item->price,
                    'product_data' => [
                        'name' => $item->name,
                    ],
                ],
            ]],
            'metadata' => [
                'purchase_id' => (string)$purchase->id,
                'item_id' => (string)$item->id,
                'user_id' => (string)$user->id,
            ],
            'payment_method_options' => ($payment_method === 'コンビニ支払い')
                ? ['konbini' => ['expires_after_days' => 3]]
                : null,
            'success_url' => url("/purchase/{$item->id}/success"),
            'cancel_url'  => url("/purchase/{$item->id}/cancel"),
        ]);

        $purchase->stripe_session_id = $session->id;
        $purchase->save();

        return redirect()->away($session->url);
    }

    public function success(Item $item)
    {
        // paid確定はWebhookで行う（100点）
        return redirect('/')->with('success', '決済を受け付けました（反映まで少し時間がかかる場合があります）');
    }

    public function cancel(Item $item)
    {
        return redirect("/item/{$item->id}")->with('error', '決済をキャンセルしました');
    }

    public function rules()
    {
        return [
            'payment_method' => [
                'required'
            ],

            'address_id' => [
                'required'
            ],
        ];
    }
}
