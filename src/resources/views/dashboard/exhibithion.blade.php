@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('page_title', '商品の出品')

@section('content')
<div class="sell-form">
    <form class="form" action="" method="" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form__group">
            <label class="form__label">商品画像</label>
            <div class="upload">
                <input type="file" id="item-photo" name="item-photo" accept="image/*" class="upload__input">
                <label for="item-photo" class="upload__btn">画像を選択する</label>
            </div>
        </div>
        <div class="item__info">
            <h2 class="info-title">商品の詳細</h2>
            <div class="form__group">
                <label class="form__label">カテゴリー</label>
                <div class="form__radio">
                    @foreach ($categories as $category)
                    <label for="" class="category">
                        <input type="checkbox" name="categories[]" value="$category->id" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                        <span>{{ $category->name }}</span>
                    </label>
                    @endforeach
                </div>
                <p class="form__error">error message</p>
            </div>
            <div class="form__group">
                <label class="form__label">商品の状態</label>
                <div class="form__content">
                    <select class="item_condition" name="item_condition">
                        <option value="" selected disabled {{ old('condition_id') ? '' : 'selected' }}>選択してください</option>
                        <!-- conditionの選択肢記述 -->
                    </select>
                </div>
                <p class="form__error">error message</p>
            </div>
        </div>
        <div class="item__info">
            <h2 class="info-title">商品名と説明</h2>
            <div class="form__group">
                <label class="form__label">商品名</label>
                <div class="form__content">
                    <input type="text" name="item_name" value="{{ old('item_name') }}">
                </div>
                <p class="form__error">error message</p>
            </div>
            <div class="form__group">
                <label class="form__label">ブランド名</label>
                <div class="form__content">
                    <input type="text" name="brand" value="{{ old('brand') }}">
                </div>
                <p class="form__error">error message</p>
            </div>
            <div class="form__group">
                <label class="form__label">商品の説明</label>
                <div class="form__content">
                    <textarea name="item_description">{{ old('item_description') }}</textarea>
                </div>
                <p class="form__error">error message</p>
            </div>
            <div class="form__group">
                <label class="form__label">販売価格</label>
                <div class="price__input">
                    <input type="text" name="item_price" value="{{ old('item_price') }}">
                </div>
                <p class="form__error">error message</p>
            </div>
        </div>
        <div class="form__btn">
            <button class="form__btn-submit" type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection