<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('purchases', function (Blueprint $table) {

            $table->string('payment_method')->nullable();
            $table->string('status')->default('pending'); // pending / paid / canceled

            $table->string('stripe_session_id')->nullable()->unique();
            $table->string('stripe_payment_intent')->nullable();

            $table->timestamp('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn([
                'payment_method',
                'status',
                'stripe_session_id',
                'stripe_payment_intent',
                'paid_at'
            ]);
        });
    }
};
