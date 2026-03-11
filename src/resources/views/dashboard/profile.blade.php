@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('page_title', 'プロフィール設定')

@section('content')
<div class="profile-form">
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="form" novalidate>
        @csrf
        <div class="form__img">
            <img src="{{ asset('storage/' . $profile->avatar_url) }}" alt="avatar" class="profile-img">
            <input type="file" id="avatar" name="avatar_url" hidden>
            <label for="avatar" class="img-select">画像を選択する</label>
            <div class='message-wrapper'>
                <p id="image-message" class="form__message"></p>
                @error('avatar_url')
                <p class="form__error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="form__group">
            <label class="form__label">ユーザー名</label>
            <div class="form__content">
                <input type="text" name="user_name" value="{{ old('user_name') ?? $profile->user_name }}">
            </div>
            @error('user_name')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form__group">
            <label class="form__label">郵便番号</label>
            <div class="form__content">
                <input type="text" name="zip_code" value="{{ old('zip_code') ?? $profile->zip_code }}">
            </div>
            @error('zip_code')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form__group">
            <label class="form__label">住所</label>
            <div class="form__content">
                <input type="text" name="address" value="{{ old('address') ?? $profile->address }}">
            </div>
            @error('address')
            <p class="form__error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form__group">
            <label class="form__label">建物名</label>
            <div class="form__content">
                <input type="text" name="building" value="{{ old('building') ?? $profile->building }}">
            </div>
        </div>

        <div class="form__btn">
            <button class="form__btn-submit" type="submit">更新する</button>
        </div>
    </form>
</div>

<script>
document.getElementById('avatar').addEventListener('change', function() {

    const message = document.getElementById('image-message');

    if (this.files.length > 0) {
        message.textContent = "画像が選択されました";
    }
});
</script>
@endsection