@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="profile-header">
    <div class="profile-header__left">
        <div class="profile-avatar">
            <img src="" alt="">
        </div>
        <p class="profile-name">ユーザー名</p>
    </div>
    <a href="" class="profile-edit">プロフィールを編集</a>
</div>
<div class="tab-wrapper">
    <div class="tab-switch">
        <!-- tab state -->
        <input type="radio" id="tab-sell" name="TAB" checked>
        <input type="radio" id="tab-buy" name="TAB">

        <!-- tab header -->
        <div class="tab-header">
            <label for="tab-sell" class="tab">出品した商品</label>
            <label for="tab-buy" class="tab">購入した商品</label>
        </div>

        <!-- tab contents -->
        <div class="tab-contents">
            <section class="tab-content" id="content-sell">
                <div class="items">
                    <!-- foreachで画像と商品名を表示：出品したもの -->
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
                        <img src="" alt="" class="item__img">
                        <p class="item__name">商品名</p>
                    </div>
                    <div class="item">
                        <img src="" alt="商品画像" class="item__img">
                        <p class="item__name">商品名</p>
                    </div>
                </div>
            </section>
            <section class="tab-content" id="content-buy">
                <div class="items">
                    <!-- foreachで画像と商品名を表示：購入したもの -->
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