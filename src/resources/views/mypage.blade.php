@extends('layouts.app')

@section('content')
<h1>マイページ</h1>

<p>名前：{{ Auth::user()->name }}</p>
<p>メール：{{ Auth::user()->email }}</p>

<a href="/mypage/edit">プロフィールを編集する</a>
@endsection