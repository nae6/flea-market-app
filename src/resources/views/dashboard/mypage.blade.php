@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="profile-header">
    <div class="profile-header__left">
        <div class="profile-avatar">
            <img src="{{ asset($profile->avatar_url) }}" alt="avatar">
        </div>
        <p class="profile-name">{{ $profile->user_name }}</p>
    </div>
    <a href="{{ route('profile.edit') }}" class="profile-edit">プロフィールを編集</a>
</div>

<div class="tab-wrapper">
    <div class="tab">
        <a href="{{ request()->fullUrlWithQuery(['page' => 'sell']) }}" class="tab__item {{ $activePage === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ request()->fullUrlWithQuery(['page' => 'buy']) }}" class="tab__item {{ $activePage === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>
    <div class="tab__content">
        <div class="items  {{ $activePage === 'sell' ? 'is-active' : '' }}">
            @forelse ($items as $item)
            <a href="{{ route('items.show', $item) }}" class="item__card link__btn">
                <img src="{{ asset($item->image_url) }}" alt="商品画像">
                <p class="item__name">{{ $item->item_name }}</p>
            </a>
            @empty
            <div></div>
            @endforelse
        </div>
        <div class="items {{ $activePage === 'buy' ? 'is-active' : '' }}">
            @forelse ($items as $item)
            <a href="{{ route('items.show', $item) }}" class="item__card link__btn">
                <img src="{{ asset($item->image_url) }}" alt="商品画像">
                <p class="item__name">{{ $item->item_name }}</p>
            </a>
            @empty
            <div></div>
            @endforelse
        </div>
    </div>
</div>
@endsection