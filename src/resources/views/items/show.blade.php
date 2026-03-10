@extends('layouts.app')

@section('content')
    <div class="item-show">

        {{-- 左：画像 --}}
        <div class="item-show__left">
            <div class="item-show__image">
                <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">
            </div>
        </div>

        {{-- 右：情報 --}}
        <div class="item-show__right">

            <h1 class="item-show__title">{{ $item->name }}</h1>

            @if (!empty($item->brand))
                <div class="item-show__brand">{{ $item->brand }}</div>
            @endif

            <div class="item-show__price">
                ¥{{ number_format($item->price) }} <span>（税込）</span>
            </div>

            {{-- アクション（いいね＋コメント＋購入ボタン） --}}
            <div class="item-show__action-row">

                <div class="item-show__icons">

                    @auth
                        <form action="/item/{{ $item->id }}/like" method="POST">
                            @csrf
                            <button type="submit" class="icon-btn">
                                <img src="{{ asset($isLiked ? 'images/icon-heart-active.png' : 'images/icon-heart.png') }}"
                                    class="icon-img" alt="like">
                                <span class="count">{{ $likeCount }}</span>
                            </button>
                        </form>
                    @else
                        <a href="/login" class="icon-btn">
                            <img src="{{ asset('images/icon-heart.png') }}" class="icon-img">
                            <span class="count">{{ $likeCount }}</span>
                        </a>
                    @endauth

                    <div class="icon-btn is-static">
                        <img src="{{ asset('images/icon-comment.png') }}" class="icon-img">
                        <span class="count">{{ $item->comments->count() }}</span>
                    </div>

                </div>

                @if (!$item->purchase)
                    <form action="/purchase/{{ $item->id }}" method="GET" class="purchase-form">
                        <div>
                            <button type="submit" class="buy-btn">
                                購入手続きへ
                            </button>
                        </div>
                    </form>
                @else
                    <div class="sold-label">
                        SOLD
                    </div>
                @endif

            </div>

            {{-- 説明 --}}
            <div class="item-show__section">
                <h3 class="section-title">商品説明</h3>
                <p class="section-text">{{ $item->description }}</p>
            </div>

            {{-- 情報 --}}
            <div class="item-show__section">
                <h3 class="section-title">商品の情報</h3>

                <div class="info-row">
                    <div class="info-label">カテゴリ</div>
                    <div class="info-value">
                        @forelse($item->categories as $category)
                            <span class="tag">{{ $category->name }}</span>
                        @empty
                            —
                        @endforelse
                    </div>
                </div>

                <div class="info-row">
                    <div class="info-label">商品の状態</div>
                    <div class="info-value">
                        <span class="tag">{{ $item->condition }}</span>
                    </div>
                </div>
            </div>

            {{-- コメント --}}
            <div class="item-show__section">
                <h3 class="section-title">
                    コメント ({{ $item->comments->count() }})
                </h3>

                <div class="comment-list">
                    @foreach ($item->comments as $comment)
                        <div class="comment-item">
                            <div class="comment-head">

                                <div class="comment-avatar">
                                    @if (optional($comment->user)->profile_image)
                                        <img src="{{ asset('storage/' . optional($comment->user)->profile_image) }}"
                                            alt="">
                                    @endif
                                </div>
                                <div class="comment-name">
                                    {{ $comment->user->name }}
                                </div>

                            </div>

                            <div class="comment-body">
                                {{ $comment->comment }}
                            </div>
                        </div>
                    @endforeach
                </div>

                @auth
                    <form action="/item/{{ $item->id }}/comment" method="POST" class="comment-form">
                        @csrf
                        <textarea name="comment" class="comment-textarea" placeholder="コメントを入力してください">{{ old('comment') }}</textarea> @error('comment')
                            <p class="error-text">{{ $message }}</p>
                        @enderror
                        <button class="comment-submit">コメントを送信する</button>
                    </form>
                @else
                    <a href="/login" class="comment-submit is-disabled">ログインしてコメントする</a>
                @endauth

            </div>

        </div>
    </div>
@endsection
