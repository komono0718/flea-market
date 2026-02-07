<h1>商品詳細</h1>

<img src="{{ $item->img_url }}" width="300">

<p>商品名：{{ $item->name }}</p>
<p>価格：¥{{ number_format($item->price) }}</p>
<p>ブランド：{{ $item->brand }}</p>
<p>説明：{{ $item->description }}</p>

<h2>コメント一覧</h2>

@forelse ($item->comments as $comment)
    <p>{{ $comment->comment }}</p>
@empty
    <p>まだコメントはありません</p>
@endforelse

<form action="/item/{{ $item->id }}/comment" method="POST">
    @csrf

    <textarea name="comment" rows="4"></textarea>

    <button type="submit">コメント送信</button>
</form>

<form action="/item/{{ $item->id }}/like" method="POST">
    @csrf
    <button type="submit">
        ❤️ いいね（{{ $item->likes->count() }}）
    </button>
</form>

<form method="POST" action="/purchase/{{ $item->id }}">
    @csrf
    <button type="submit">購入する</button>
</form>