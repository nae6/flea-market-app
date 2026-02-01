@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('page_title', 'プロフィール設定')

@section('content')
<div class="profile-form">
    <form class="form" action="" method="" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="form__img">
            <div class="profile-img" id="avatar-preview"></div>
            <input type="file" id="avatar" name="avatar" accept="image/*" class="profile-img__input" value="{{ old('avatar') }}">
            <label for="avatar" class="img-select">画像を選択する</label>
        </div>
        <div class="form__group">
            <label class="form__label">ユーザー名</label>
            <div class="form__content">
                <input type="text" name="name" value="{{ old('name') }}">
            </div>
            <p class="form__error">error message</p>
        </div>
        <div class="form__group">
            <label class="form__label">郵便番号</label>
            <div class="form__content">
                <input type="text" name="postal_code" value="{{ old('postal_code') }}">
            </div>
            <p class="form__error">error message</p>
        </div>
        <div class="form__group">
            <label class="form__label">住所</label>
            <div class="form__content">
                <input type="text" name="address" value="{{ old('address') }}">
            </div>
            <p class="form__error">error message</p>
        </div>
        <div class="form__group">
            <label class="form__label">建物名</label>
            <div class="form__content">
                <input type="text" name="building" value="{{ old('building') }}">
            </div>
            <p class="form__error">error message</p>
        </div>
        <div class="form__btn">
            <button class="form__btn-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection