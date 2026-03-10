@extends('layouts.app')

@section('content')
    <div class="container purchase-address-page">

        <h2>配送先住所の変更</h2>

        @if ($errors->any())
            <div style="color:red;margin-bottom:20px;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('purchase.address.update', $item) }}">
            @csrf

            <div class="form-group">
                <label>郵便番号</label>
                <input name="postcode" value="{{ old('postcode', $shipping['postcode'] ?? '') }}"
                    style="width:100%;padding:10px;">
            </div>

            <div class="form-group">
                <label>住所</label>
                <input name="address" value="{{ old('address', $shipping['address'] ?? '') }}"
                    style="width:100%;padding:10px;">
            </div>

            <div class="form-group">
                <label>建物名</label>
                <input name="building" value="{{ old('building', $shipping['building'] ?? '') }}"
                    style="width:100%;padding:10px;">
            </div>

            <button type="submit"
                style="background:#ff5a5f;color:#fff;border:none;padding:12px;width:100%;font-weight:bold;cursor:pointer;margin-top:20px;">
                更新して戻る
            </button>

        </form>

    </div>
@endsection
