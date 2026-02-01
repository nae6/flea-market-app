@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchases.css') }}">
@endsection

@section('page_title', '住所の変更')

@section('content')
<div class="profile-form">
    <form class="form" action="" method="" novalidate>
        @csrf
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