@extends('layouts.app')

@section('content')

<div class="profile-edit-wrapper">

    <h1 class="profile-title">プロフィール設定</h1>

    <form action="/mypage/update" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="profile-image-row">

            {{-- 画像表示 --}}
            @if (!empty($user->profile_image))
                <img id="profile-preview"
                     src="{{ asset('storage/'.$user->profile_image) }}"
                     class="profile-icon-img">
            @else
                <div id="profile-placeholder" class="profile-icon"></div>
                <img id="profile-preview"
                     class="profile-icon-img"
                     style="display:none;">
            @endif

            {{-- 画像選択 --}}
            <label for="profile-image-input" class="image-upload-btn">
                画像を選択する
            </label>

            <input type="file" name="image" id="profile-image-input" hidden>

        </div>

        <div class="form-block">
            <label>ユーザー名</label>
            <input type="text" name="name" value="{{ $user->name }}">
        </div>

        <div class="form-block">
            <label>郵便番号</label>
            <input type="text" name="postcode" value="{{ $user->postcode }}">
        </div>

        <div class="form-block">
            <label>住所</label>
            <input type="text" name="address" value="{{ $user->address }}">
        </div>

        <div class="form-block">
            <label>建物名</label>
            <input type="text" name="building" value="{{ $user->building }}">
        </div>

        <button type="submit" class="auth-button">
            更新する
        </button>

    </form>

</div>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const input = document.getElementById('profile-image-input');
    const preview = document.getElementById('profile-preview');
    const placeholder = document.getElementById('profile-placeholder');

    if(!input) return;

    input.addEventListener('change', function(e){

        const file = e.target.files[0];
        if(!file) return;

        const reader = new FileReader();

        reader.onload = function(event){

            preview.src = event.target.result;
            preview.style.display = 'block';

            if(placeholder){
                placeholder.style.display = 'none';
            }

        };

        reader.readAsDataURL(file);

    });

});

</script>

@endsection