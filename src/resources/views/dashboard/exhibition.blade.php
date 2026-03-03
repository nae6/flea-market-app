@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('page_title', '商品の出品')

@section('content')
<div class="sell-form">
    <form class="form" action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form__group">
            <label class="form__label">商品画像</label>
            <div class="upload">
                <img src="#" alt="item_image" class="upload__img"></img>
                <input type="file" id="item-photo" name="image_url" hidden>
                <label for="item-photo" class="upload__btn">画像を選択する</label>
            </div>
        </div>

        <div class="item__info">
            <h2 class="info-title">商品の詳細</h2>
            <div class="form__group">
                <label class="form__label">カテゴリー</label>
                <div class="form__radio">
                    @foreach ($categories as $category)
                    <label class="category">
                        <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                        <span>{{ $category->category_name }}</span>
                    </label>
                    @endforeach
                </div>
                @error('categories')
                <p class="form__error">{{ $message }}</p>
                @enderror
                @error('categories.*')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>
            <div class="form__group">
                <label class="form__label">商品の状態</label>
                <div class="form__content">
                    <select class="item_condition" name="item_condition">
                        <option value="" selected disabled {{ old('condition_id') ? '' : 'selected' }}>選択してください</option>
                        <!-- conditionの選択肢記述 -->
                        <option value="1">良好</option>
                        <option value="2">目立った傷や汚れなし</option>
                        <option value="3">やや傷や汚れあり</option>
                        <option value="4">状態が悪い</option>
                    </select>
                </div>
                @error('condition')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="item__info">
            <h2 class="info-title">商品名と説明</h2>
            <div class="form__group">
                <label class="form__label">商品名</label>
                <div class="form__content">
                    <input type="text" name="item_name" value="{{ old('item_name') }}">
                </div>
                @error('item_name')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">ブランド名</label>
                <div class="form__content">
                    <input type="text" name="brand" value="{{ old('brand') }}">
                </div>
            </div>

            <div class="form__group">
                <label class="form__label">商品の説明</label>
                <div class="form__content">
                    <textarea name="item_description">{{ old('item_description') }}</textarea>
                </div>
                @error('description')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">販売価格</label>
                <div class="price__input">
                    <input type="text" name="item_price" value="{{ old('item_price') }}">
                </div>
                @error('price')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form__btn">
            <button class="form__btn-submit" type="submit">出品する</button>
        </div>
    </form>
</div>
@endsection