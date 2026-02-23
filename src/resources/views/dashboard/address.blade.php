@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/address.css') }}">
@endsection

@section('page_title', '住所の変更')

@section('content')
<div class="profile-form">
    <form class="form" action="{{ route('address.confirm', $item) }}" method="post" novalidate>
        @csrf
        <div class="form__group">
            <label class="form__label">郵便番号</label>
            <div class="form__content">
                <input type="text" name="zip_code" value="{{ old('zip_code') }}">
            </div>
            @error('zip_code')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <label class="form__label">住所</label>
            <div class="form__content">
                <input type="text" name="address" value="{{ old('address') }}">
            </div>
            @error('address')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <label class="form__label">建物名</label>
            <div class="form__content">
                <input type="text" name="building" value="{{ old('building') }}">
            </div>
        </div>
        <div class="form__btn">
            <button class="form__btn-submit" type="submit">更新する</button>
        </div>
    </form>
</div>
@endsection