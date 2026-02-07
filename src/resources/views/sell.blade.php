@extends('layouts.app')

@section('content')
<h1>商品出品</h1>

<form method="POST" action="/sell">
    @csrf

    <div>
        <label>商品名</label><br>
        <input type="text" name="name">
    </div>

    <div>
        <label>価格</label><br>
        <input type="number" name="price">
    </div>

    <div>
        <label>ブランド名</label><br>
        <input type="text" name="brand">
    </div>

    <div>
        <label>説明</label><br>
        <textarea name="description"></textarea>
    </div>

    <div>
        <label>画像URL（仮）</label><br>
        <input type="text" name="img_url">
    </div>

    <button type="submit">出品する</button>
</form>
@endsection