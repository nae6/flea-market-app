@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="tab-wrapper">
    <div class="tab-switch">
        <!-- tab state -->
        <input type="radio" id="tab-recommend" name="TAB" checked>
        <input type="radio" id="tab-my-list" name="TAB">

        <!-- tab header -->
        <div class="tab-header">
            <label for="tab-recommend" class="tab">おすすめ</label>
            <label for="tab-my-list" class="tab">マイリスト</label>
        </div>

        <!-- tab contents -->
        <div class="tab-contents">
            <section class="tab-content" id="content-recommend">
                <div class="items">
                    <!-- foreachで画像と商品名を表示：おすすめ -->
                    <div class="item">
                        <img src="" alt="商品画像" class="item__img">
                        <p class="item__name">商品名</p>
                    </div>
                    <div class="item">
                        <img src="" alt="商品画像" class="item__img">
                        <p class="item__name">商品名</p>
                    </div>
                    <div class="item">
                        <img src="" alt="商品画像" class="item__img">
                        <p class="item__name">商品名</p>
                    </div>
                    <div class="item">
                        <img src="" alt="商品画像" class="item__img">
                        <p class="item__name">商品名</p>
                    </div>
                    <div class="item">
                        <img src="" alt="商品画像" class="item__img">
                        <p class="item__name">商品名</p>
                    </div>
                </div>
            </section>
            <section class="tab-content" id="content-my-list">
                <div class="items">
                    <!-- foreachで画像と商品名を表示：いいねのみ -->
                    <div class="item">
                        <img src="" alt="商品画像" class="item__img">
                        <p class="item__name">商品名</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection