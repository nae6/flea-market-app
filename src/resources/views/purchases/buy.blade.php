@extends('layouts.common')

@section('css')
<link rel="stylesheet" href="{{ asset('css/buy.css') }}">
@endsection

@section('content')
<div class="buy-wrapper">
    <div class="buy__info buy__item">
        <img src="" alt="">
        <div>
            <p class="buy__item-name">商品名</p>
            <p class="buy__item-price">¥ 47,000</p>
        </div>
    </div>
    <div class="buy__info buy__payment">
        <p class="payment__title">支払い方法</p>
        <select name="" id="" class="payment__select">
            <option value="" disabled selected>選択してください</option>
            <option value="pay-in-store">コンビニ払い</option>
            <option value="pay-credit-card">カード支払い</option>
        </select>
    </div>
    <div class="buy__info buy__shipping">
        <div class="shipping">
            <p class="shipping__title">配送先</p>
            <button>変更する</button>
        </div>
        <p class="shipping-address__detail">
            〒 XXX-YYYY<br>
            ここには住所と建物が入ります
        </p>
    </div>
    <div class="buy__confirm">
        <table>
            <tr class="table__row">
                <th>商品代金</th>
                <td>¥ 47,000</td>
            </tr>
            <tr class="table__row">
                <th>支払い方法</th>
                <td>コンビニ払い</td>
            </tr>
        </table>
    </div>
    <div class="buy__btn">
        <button class="form__btn-submit" type="submit">購入する</button>
    </div>
</div>
@endsection