@extends('layouts.app')

@section('content')

<div class="container">

    <div class="tabs-line">
<a href="/?keyword={{ request('keyword') }}">おすすめ</a>
<a href="/?tab=mylist&keyword={{ request('keyword') }}">マイリスト</a>
    </div>

    <div class="item-grid">
        @foreach ($items as $item)

            <a href="/item/{{ $item->id }}" class="item-card-link">

                <div class="item-image-wrap" style="position:relative;">

                    {{-- SOLD表示 --}}
                    @if ($item->purchase)
                        <div style="
                            position:absolute;
                            top:10px;
                            left:10px;
                            background:red;
                            color:white;
                            padding:4px 10px;
                            font-size:12px;
                            font-weight:bold;
                            z-index:10;
                        ">
                            SOLD
                        </div>
                    @endif

                    <img src="{{ asset('storage/' . $item->img_url) }}" alt="{{ $item->name }}">

                </div>

                <div class="item-name">{{ $item->name }}</div>

            </a>

        @endforeach
    </div>

</div>

@endsection