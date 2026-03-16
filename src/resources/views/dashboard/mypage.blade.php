@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
@endsection

@section('content')
<div class="profile-header">
    <div class="profile-header__left">
        <div class="profile-avatar">
            @if ($profile?->avatar_url)
            <img src="{{ asset('storage/' . $profile->avatar_url) }}" alt="avatar">
            @else
            <div></div>
            @endif
        </div>
        <p class="profile-name">{{ $profile->user_name ?? $user->name }}</p>
    </div>
    <a href="{{ route('profile.edit') }}" class="profile-edit">プロフィールを編集</a>
</div>

<div class="tab-wrapper">
    <div class="tab">
        <a href="{{ request()->fullUrlWithQuery(['page' => 'sell']) }}" class="tab__item {{ $activePage === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ request()->fullUrlWithQuery(['page' => 'buy']) }}" class="tab__item {{ $activePage === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>
    <div class="tab__content">
        @if ($activePage === 'sell')
        <div class="items  {{ $activePage === 'sell' ? 'is-active' : '' }}">
            @forelse ($items as $sell_item)
            <a href="{{ route('items.show', $sell_item->id) }}" class="item__card link__btn {{ $sell_item->status === 2 ? 'sold' : '' }}">
                <img src="{{ asset('storage/' . $sell_item->image_url) }}" alt="商品画像">
                <p class="item__name">{{ $sell_item->item_name }}</p>
            </a>
            @empty
            <div></div>
            @endforelse
        </div>
        @elseif ($activePage === 'buy')
        <div class="items {{ $activePage === 'buy' ? 'is-active' : '' }}">
            @forelse ($items as $buy_item)
            <a href="{{ route('items.show', $buy_item->item->id) }}" class="item__card link__btn">
                <img src="{{ asset('storage/' . $buy_item->item->image_url) }}" alt="商品画像">
                <p class="item__name">{{ $buy_item->item->item_name }}</p>
            </a>
            @empty
            <div></div>
            @endforelse
        </div>
        @endif
    </div>
</div>
@endsection