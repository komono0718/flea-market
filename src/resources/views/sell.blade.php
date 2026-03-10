@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="sell-wrapper">

            <h1 class="sell-title">商品の出品</h1>

            <form method="POST" action="/sell" enctype="multipart/form-data">
                @csrf


                {{-- 商品画像 --}}
                <div class="sell-section">

                    <h3 class="section-heading">商品画像</h3>

                    <label class="sell-image-box">

                        <img id="image-preview" style="display:none;width:100%;height:100%;object-fit:cover;">

                        <span class="image-select-text" id="image-text">画像を選択する</span>

                        <input type="file" name="image" id="image-input" hidden>

                    </label>

                </div>

                @error('image')
                    <p class="error-text">{{ $message }}</p>
                @enderror


                {{-- 商品の詳細 --}}
                <div class="sell-section">

                    <h2 class="section-heading with-line">商品の詳細</h2>

                    <div class="form-block">

                        <label>カテゴリー</label>

                        <div class="category-tags">

                            @foreach ($categories as $category)
                                <label class="category-tag">

                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}">

                                    <span>{{ $category->name }}</span>

                                </label>
                            @endforeach

                        </div>

                    </div>

                    <div class="form-block">

                        <label>商品の状態</label>

                        <select name="condition">

                            <option value="">選択してください</option>
                            <option value="良好">良好</option>
                            <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                            <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                            <option value="状態が悪い">状態が悪い</option>

                        </select>

                    </div>

                </div>


                {{-- 商品名と説明 --}}
                <div class="sell-section">

                    <h2 class="section-heading with-line">商品名と説明</h2>

                    <div class="form-block">
                        <label>商品名</label>
                        <input type="text" name="name">
                    </div>

                    <div class="form-block">
                        <label>ブランド名</label>
                        <input type="text" name="brand">
                    </div>

                    <div class="form-block">
                        <label>商品の説明</label>
                        <textarea name="description"></textarea>
                    </div>

                    <div class="form-block">
                        <label>販売価格</label>
                        <input type="number" name="price">
                    </div>

                </div>


                <button type="submit" class="sell-submit-btn">
                    出品する
                </button>

            </form>

        </div>

    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const input = document.getElementById("image-input")
            const preview = document.getElementById("image-preview")
            const text = document.getElementById("image-text")

            input.addEventListener("change", function(e) {

                const file = e.target.files[0]

                if (!file) return

                const reader = new FileReader()

                reader.onload = function(event) {

                    preview.src = event.target.result
                    preview.style.display = "block"

                    text.style.display = "none"

                }

                reader.readAsDataURL(file)

            })

        })
    </script>
@endsection
