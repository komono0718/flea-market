<h1>商品一覧</h1>

@if (Auth::check())
    <p style="color:green;">ログイン中（ID: {{ Auth::id() }}）</p>
@else
    <p style="color:red;">未ログイン</p>
@endif

@foreach ($items as $item)
    <div style="margin-bottom:30px;">
        <img src="{{ $item->img_url }}" width="200">

        @if ($item->purchase)
    <p style="color:red; font-weight:bold;">Sold</p>
@endif

        <p>
            <a href="/item/{{ $item->id }}">
                {{ $item->name }}
            </a>
            <a href="/">おすすめ</a>
<a href="/?tab=mylist">マイリスト</a>
        </p>

        <p>¥{{ number_format($item->price) }}</p>
    </div>
@endforeach