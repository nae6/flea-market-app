@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="verify-message">
    <p  class="verify-message">
        登録していただいたメールアドレスに認証メールを送付しました。<br>メール認証を完了してください。
    </p>
    <form action="{{ route('verification.notice') }}" method="GET">
        @csrf
        <button type="submit">認証はこちらから</button>
    </form>
    <form action="{{ route('verification.send') }}" method="POST">
        @csrf
        <button type="submit">認証メールを再送する</button>
    </form>
</div>
@endsection
