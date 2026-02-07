@extends('layouts.app')

@section('content')
<h1>プロフィール編集</h1>

<form action="/mypage/edit" method="post">
    @csrf

    <div>
        <label>名前</label><br>
        <input type="text" value="{{ Auth::user()->name }}">
    </div>

    <div>
        <label>メール</label><br>
        <input type="email" value="{{ Auth::user()->email }}">
    </div>

    <button type="submit">保存</button>
</form>

<a href="/mypage">マイページに戻る</a>
@endsection