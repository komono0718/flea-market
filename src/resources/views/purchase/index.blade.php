@extends('layouts.app')

@section('content')
    <div class="purchase-page">
        <div class="purchase-layout">

            {{-- =========================
        左カラム
    ========================== --}}
            <div class="purchase-left">

                {{-- 商品情報（画像＋名前＋価格） --}}
                <div class="purchase-item-row">
                    <div class="purchase-image">
                        <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
                    </div>

                    <div class="purchase-item-info">
                        <h3 class="purchase-item-name">
                            {{ $item->name }}
                        </h3>
                        <div class="purchase-item-price">
                            ¥{{ number_format($item->price) }}（税込）
                        </div>
                    </div>
                </div>

                {{-- 支払い方法 --}}
                <div class="purchase-section">
                    <h4>支払い方法</h4>

                    <form method="POST" action="/purchase/{{ $item->id }}/payment">
                        @csrf
                        <select name="payment_method" class="purchase-select" onchange="this.form.submit()">
                            <option value="コンビニ支払い" {{ ($payment_method ?? '') === 'コンビニ支払い' ? 'selected' : '' }}>
                                コンビニ支払い
                            </option>
                            <option value="カード支払い" {{ ($payment_method ?? '') === 'カード支払い' ? 'selected' : '' }}>
                                カード支払い
                            </option>
                        </select>
                    </form>
                </div>

                {{-- 配送先 --}}
                <div class="purchase-section">
                    <div class="purchase-address-head">
                        <h4>配送先</h4>
                        <a href="/purchase/{{ $item->id }}/address" class="address-link">
                            変更する
                        </a>
                    </div>

                    <div class="purchase-address">
                        <div>〒{{ $shipping['postcode'] ?? '' }}</div>
                        <div>{{ $shipping['address'] ?? '' }}</div>
                        <div>{{ $shipping['building'] ?? '' }}</div>
                    </div>
                </div>

            </div>

            {{-- =========================
         右カラム
    ========================== --}}
            <div class="purchase-right">

                {{-- サマリー --}}
                <div class="purchase-summary">
                    <div class="summary-row">
                        <span>商品代金</span>
                        <span>¥{{ number_format($item->price) }}</span>
                    </div>
                    <div class="summary-row">
                        <span>支払い方法</span>
                        <span>{{ $payment_method ?? 'コンビニ支払い' }}</span>
                    </div>
                </div>

                {{-- 購入ボタン --}}
                <form method="POST" action="/purchase/{{ $item->id }}/checkout">
                    @csrf
                    <button type="submit" class="purchase-btn">
                        購入する
                    </button>
                </form>

            </div>

        </div>
    </div>
@endsection
