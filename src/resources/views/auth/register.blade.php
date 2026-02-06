@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('page_title', '会員登録')

@section('content')
<div class="auth-form">
    <form class="form" action="/register" method="POST" novalidate>
        @csrf
        <div class="form__group">
            <label class="form__label">ユーザー名</label>
            <div class="form__content">
                <input type="text" name="name" value="{{ old('name') }}">
            </div>
            @error('name')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <label class="form__label">メールアドレス</label>
            <div class="form__content">
                <input type="email" name="email" value="{{ old('email') }}">
            </div>
            @error('email')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <label class="form__label">パスワード</label>
            <div class="form__content">
                <input type="password" name="password">
            </div>
            @error('password')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__group">
            <label class="form__label">確認用パスワード</label>
            <div class="form__content">
                <input type="password" name="password_confirmation">
            </div>
            @error('password_confirmation')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>
        <div class="form__btn">
            <button class="form__btn-submit" type="submit">登録する</button>
        </div>
    </form>
    <div class="auth__link">
        <a class="link" href="{{ route('login') }}">ログインはこちら</a>
    </div>
</div>
@endsection