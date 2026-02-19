@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('search_extra')
<input type="hidden" name="tab" value="{{ $activeTab }}">
@endsection

@section('content')
<div class="tab-wrapper">
    <div class="tab">
        <a href="{{ route('index') }}" class="tab__item {{ $activeTab === 'recommend' ? 'active' : '' }}">おすすめ</a>
        <a href="{{ request()->fullUrlWithQuery(['tab' => 'mylist']) }}" class="tab__item {{ $activeTab === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>
    <div class="tab__content">
        <div class="items  {{ $activeTab === 'recommend' ? 'is-active' : '' }}">
            @forelse ($items as $item)
            <a href="{{ route('items.show', $item) }}" class="item__card link__btn {{ $item->status === 2 ? 'sold' : '' }}">
                <img src="{{ asset($item->image_url) }}" alt="商品画像">
                <p class="item__name">{{ $item->item_name }}</p>
            </a>
            @empty
            <div></div>
            @endforelse
        </div>
        <div class="items {{ $activeTab === 'mylist' ? 'is-active' : '' }}">
            @if (auth()->guest())
            <div></div>
            @else
            @forelse ($items as $item)
            <a href="{{ route('items.show', $item) }}" class="item__card link__btn {{ $item->status === 2 ? 'sold' : '' }}">
                <img src="{{ asset($item->image_url) }}" alt="商品画像">
                <p class="item__name">{{ $item->item_name }}</p>
            </a>
            @empty
            <div></div>
            @endforelse
            @endif
        </div>
    </div>
</div>
@endsection