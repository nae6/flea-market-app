@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('page_title', 'ログイン')

@section('content')
<div class="auth-form">
    <form class="form" action="" method="" novalidate>
        @csrf
        <div class="form__group">
            <label class="form__label">メールアドレス</label>
            <div class="form__content">
                <input type="email" name="email" value="{{ old('email') }}">
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
        <div class="form__btn">
            <button class="form__btn-submit" type="submit">ログインする</button>
        </div>
    </form>
    <div class="auth__link">
        <a class="link" href="/register">会員登録はこちら</a>
    </div>
</div>
@endsection