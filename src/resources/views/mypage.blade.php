@extends('layouts.app')

@section('content')

    <div class="container">

        {{-- プロフィールヘッダー --}}
        <div class="profile-header">

            <div class="profile-left">
                @if ($user->profile_image)
                    <img src="{{ asset('storage/' . $user->profile_image) }}" class="profile-icon-img">
                @endif

                <div class="profile-name">
                    {{ $user->name }}
                </div>
            </div>

            <a href="/mypage/edit" class="profile-edit-btn">
                プロフィールを編集
            </a>
        </div>

        {{-- タブ --}}
        <div class="profile-tabs">
            <a href="?tab=sell" class="{{ request('tab') !== 'buy' ? 'active' : '' }}">
                出品した商品
            </a>

            <a href="?tab=buy" class="{{ request('tab') === 'buy' ? 'active' : '' }}">
                購入した商品
            </a>
        </div>

        {{-- 商品グリッド --}}
        <div class="item-grid">

            @if (request('tab') === 'buy')
                @forelse ($purchases as $purchase)
                    <div class="item-card">
                        <img src="{{ asset('storage/' . $purchase->item->img_url) }}">
                        <div class="item-body">
                            <div class="item-name">
                                {{ $purchase->item->name }}
                            </div>
                            <div class="item-price">
                                ¥{{ number_format($purchase->item->price) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p>まだ購入した商品はありません</p>
                @endforelse
            @else
                @forelse ($items as $item)
                    <div class="item-card">
                        <img src="{{ asset('storage/' . $item->img_url) }}">
                        <div class="item-body">
                            <div class="item-name">
                                {{ $item->name }}
                            </div>
                            <div class="item-price">
                                ¥{{ number_format($item->price) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p>まだ出品した商品はありません</p>
                @endforelse
            @endif

        </div>

    </div>

@endsection
