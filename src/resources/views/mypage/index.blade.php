@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div>
    <div class="form__img">
            <div class="profile-img" id="avatar-preview"></div>
            <input type="file" id="avatar" name="avatar" accept="image/*" class="profile-img__input" value="{{ old('avatar') }}">
            <label for="avatar" class="img-select">画像を選択する</label>
        </div>
</div>
<div class="top-wrapper">
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
                <div class="content-wrapper">
                    <!-- foreachで画像と商品名を表示：すべて -->
                    <div class="items">
                        <img src="" alt="">
                        <p>商品名</p>
                    </div>
                    <div class="items">
                        <img src="" alt="">
                        <p>商品名</p>
                    </div>
                    <div class="items">
                        <img src="" alt="">
                        <p>商品名</p>
                    </div>
                </div>
            </section>
            <section class="tab-content" id="content-my-list">
                <div class="content-wrapper">
                    <!-- foreachで画像と商品名を表示：いいねのみ -->
                    <div class="items">
                        <img src="" alt="">
                        <p>商品名</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection