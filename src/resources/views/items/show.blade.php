@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('content')
<div class="detail">
    <div class="detail__img">
        <img src="{{ asset($item->image_url) }}" alt="商品画像">
    </div>
    <div class="detail__content">
        <h1 class="detail__title">{{ $item->item_name }}</h1>
        <p class="detail__brand">{{ $item->brand }}</p>
        <p class="detail__price">¥<span>{{ $item->price}}</span> (税込)</p>
        <div class="detail__icons">
            <!-- いいねをクリックで登録・解除切り替え -->
            <form action="{{ route('items.favorite', $item) }}" method="POST" class="icons__flex">
                @csrf
                <button type="submit">
                    @if($isFavorited)
                    <img src="{{ asset('images/heart_logo_liked.png') }}" alt="いいねアイコン/liked" class="detail__icon">
                    @else
                    <img src="{{ asset('images/heart_logo_default.png') }}" alt="いいねアイコン/default" class="detail__icon">
                    @endif
                </button>
                <span>{{ $item->favorites_count }}</span>
            </form>
            <div class="icons__flex">
                <img src="{{ asset('images/bubble_logo.png') }}" alt="コメントアイコン" class="detail__icon">
                <span>{{ $item->comments_count }}</span>
            </div>
        </div>
        <a href="{{ route('buy', $item) }}" class="link__btn form__btn-submit">購入手続きへ</a>
        <div class="detail__content">
            <h2>商品説明</h2>
            <p>{{ $item->description }}</p>
        </div>
        <div class="detail__content">
            <h2>商品の情報</h2>
            <div class="detail__info">
                <h3>カテゴリー</h3>
                @foreach ($item->categories as $category)
                <p class="detail__category">{{ $category->category_name }}</p>
                @endforeach
            </div>
            <div class="detail__info">
                <h3>商品の状態</h3>
                <p>{{ $item->condition_label }}</p>
            </div>
        </div>
        <div class="comment-wrapper">
            <h2>コメント(1)</h2>
            @foreach ($item->comments as $comment)
            <div class="comment__list">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <img src="" alt="コメントユーザーのアイコン">
                    </div>
                    <span class="profile-name">{{ $comment->user->name }}</span>
                </div>
                <p>{{ $comment->content }}</p>
            </div>
            @endforeach
            <form action="{{ route('comments.store', $item) }}" method="POST" class="comment__form">
                @csrf
                <label for="content" class="comment__header">商品へのコメント</label>
                <textarea name="content"></textarea>
                @error('content')
                <div class="form__error">{{ $message }}</div>
                @enderror
                <button type="submit" class="form__btn-submit">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection