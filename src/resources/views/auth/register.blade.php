@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('page_title', '会員登録')

@section('content')
<div class="auth-form">
    <form class="form" action="" method="" novalidate>
        @csrf
        <div class="form__group">
            <label class="form__label">ユーザー名</label>
            <div class="form__content">
                <input type="text" name="user_name" value="">
            </div>
            <p class="form__error">error message</p>
        </div>
        <div class="form__group">
            <label class="form__label">メールアドレス</label>
            <div class="form__content">
                <input type="email" name="email" value="">
            </div>
            <p class="form__error">error message</p>
        </div>
        <div class="form__group">
            <label class="form__label">パスワード</label>
            <div class="form__content">
                <input type="password" name="password">
            </div>
            <p class="form__error">error message</p>
        </div>
        <div class="form__group">
            <label class="form__label">確認用パスワード</label>
            <div class="form__content">
                <input type="password" name="password_confirmation">
            </div>
            <p class="form__error">error message</p>
        </div>
        <div class="form__btn">
            <button class="form__btn-submit" type="submit">登録する</button>
        </div>
    </form>
    <div class="auth__link">
        <a class="link" href="/auth/login">ログインはこちら</a>
    </div>
</div>
@endsection