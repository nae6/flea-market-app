@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="detail">
    <div class="detail__img">
        <img src="" alt="商品画像">
    </div>
    <div class="detail__content">
        <h1 class="detail__title">商品名がここに入る</h1>
        <p class="detail__brand">ブランド名</p>
        <p class="detail__price">¥<span>47,000 </span>(税込)</p>
        <div>
            <!-- いいねをクリックで登録・解除切り替え -->
            <div>
                <img src="{{ asset('icons/white-heart.svg') }}" alt="いいねアイコン" class="detail__icon">
                <span>3</span>
            </div>
            <!-- コメントが増えたら表示数が増加 -->
            <div>
                <img src="{{ asset('icons/white-bubble.svg') }}" alt="コメントアイコン" class="detail__icon">
                <span>1</span>
            </div>
        </div>
        <button class="form__btn-submit">購入手続きへ</button>
        <div class="detail__content">
            <h2>商品説明</h2>
            <!-- 商品説明を表示する -->
            <p>カラー：グレー<br><br>新品<br>商品の状態は良好です。傷もありません。<br><br>購入後、即日発送いたします。</p>
        </div>
        <div class="detail__content">
            <h2>商品の情報</h2>
            <div class="detail__info">
                <!-- 選択されたカテゴリが表示される -->
                <h3>カテゴリー</h3>
                <p class="detail__category">洋服</p>
                <p class="detail__category">メンズ</p>
            </div>
            <div class="detail__info">
                <h3>商品の状態</h3>
                <p>良好</p>
            </div>
        </div>
        <div class="comment-wrapper">
            <h2>コメント(1)</h2>
            <!-- foreachでコメント表示 -->
            <div class="comment__list">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="" alt="">
                    </div>
                    <span class="profile-name">admin</span>
                </div>
                <p>こちらにコメントが入ります。</p>
            </div>
            <form action="" class="comment__form">
                <label for="comment" class="comment__header">商品へのコメント</label>
                <textarea name="comment"></textarea>
                <button type="submit" class="form__btn-submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection