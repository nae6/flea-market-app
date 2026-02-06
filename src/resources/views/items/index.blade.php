@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="tab-wrapper">
    <div class="tab-switch">
        <!-- tab state -->
        <input type="radio" id="recommend" name="TAB" checked>
        <input type="radio" id="my-list" name="TAB">

        <!-- tab header -->
        <div class="tab-header">
            <a href="{{ route('/', ['tab' => 'tab1']) }}" class="tab">おすすめ</a>
            <a href="{{ route('/?tab=mylist', ['tab' => 'tab2']) }}" class="tab">マイリスト</a>
        </div>

        <!-- tab contents -->
        <div class="tab-contents">
            @if($activeTab === 'tab1')
            <section class="tab-content" id="content-recommend">
                <div class="items">
                    <!-- foreachで画像と商品名を表示：おすすめ -->
                    <div class="item">
                        <img src="" alt="商品画像" class="item__img">
                        <p class="item__name">商品名</p>
                    </div>
                </div>
            </section>
            @elseif($activeTab === 'tab2')
            <section class="tab-content" id="content-my-list">
                <div class="items">
                    <!-- foreachで画像と商品名を表示：いいねのみ -->
                    <div class="item">
                        <img src="" alt="商品画像" class="item__img">
                        <p class="item__name">商品名</p>
                    </div>
                </div>
            </section>
            @endif
        </div>
    </div>
</div>
@endsection