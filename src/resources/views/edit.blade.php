@extends('layouts.app')

@section('content')
    <div class="profile-edit-wrapper">


        <h2 class="profile-title">プロフィール設定</h2>

        <form method="POST" action="/mypage/update" enctype="multipart/form-data" class="profile-form">
            @csrf

            {{-- 画像 --}}
            <div class="profile-image-row">
                <div class="profile-avatar">
                    @if (Auth::user()->profile_image)
                        <img src="{{ asset('storage/' . Auth::user()->profile_image) }}">
                    @endif
                </div>

                <label class="image-upload-btn">
                    画像を選択する
                    <input type="file" name="image" hidden>
                </label>
            </div>

            {{-- 名前 --}}
            <div class="form-block">
                <label>ユーザー名</label>
                <input type="text" name="name" value="{{ Auth::user()->name }}">
            </div>

            {{-- 郵便番号 --}}
            <div class="form-block">
                <label>郵便番号</label>
                <input type="text" name="postcode" value="{{ $user->postcode }}">
            </div>

            {{-- 住所 --}}
            <div class="form-block">
                <label>住所</label>
                <input type="text" name="address" value="{{ Auth::user()->address }}">
            </div>

            {{-- 建物名 --}}
            <div class="form-block">
                <label>建物名</label>
                <input type="text" name="building" value="{{ Auth::user()->building }}">
            </div>

            {{-- メール（表示のみ） --}}
            <div class="form-block">
                <label>メール</label>
                <input type="email" value="{{ Auth::user()->email }}" disabled>
            </div>

            <button type="submit" class="auth-button">
                更新する
            </button>

        </form>

    </div>
@endsection
