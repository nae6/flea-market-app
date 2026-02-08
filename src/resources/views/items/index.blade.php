@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="tab-wrapper">
    <div class="tab">
        <a href="{{ request()->fullUrlWithQuery(['tab' => null]) }}" class="tab__item {{ $activeTab === 'recommend' ? 'active' : '' }}">おすすめ</a>
        <a href="{{ request()->fullUrlWithQuery(['tab' => 'mylist']) }}" class="tab__item {{ $activeTab === 'mylist' ? 'active' : '' }}">マイリスト</a>
    </div>
    <div class="tab__content">
        <div class="items  {{ $activeTab === 'recommend' ? 'is-active' : '' }}">
            <!-- forelseで表示 -->
            <div class="item__card">
                <img src="" alt="">
                <p class="item__name">name</p>
            </div>
        </div>
        <div class="items {{ $activeTab === 'mylist' ? 'is-active' : '' }}">
            @if (auth()->guest())
            <div></div>
            @else
            <!-- forelseで表示 -->
            <div class="item__card">
                <img src="" alt="">
                <p class="item__name">name</p>
            </div>
            <div class="item__card">
                <img src="" alt="">
                <p class="item__name">name</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection