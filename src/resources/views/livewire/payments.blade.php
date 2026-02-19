<div class="buy-wrapper">
    <div class="buy__info buy__item">
        <img src="{{ $item->image_url }}" alt="商品画像">
        <div>
            <p class="buy__item-name">{{ $item->item_name }}</p>
            <p class="buy__item-price">¥ {{ number_format($item->price) }}</p>
        </div>
    </div>

    <div class="buy__info buy__payment">
        <label class="payment__title">支払い方法</label>
        <select wire:model.live="selectPayment" name="payment_method" id="" class="payment__select">
            <option value="" disabled selected>選択してください</option>
            <option value="pay-in-store">コンビニ払い</option>
            <option value="pay-credit-card">カード支払い</option>
        </select>
    </div>

    <div class="buy__info buy__shipping">
        <div class="shipping">
            <p class="shipping__title">配送先</p>
            <a href="{{ route('address', $item) }}">変更する</a>
        </div>
        <p class="shipping-address__detail">
            〒 {{ $shipping['zip_code'] ?? optional($profile)->zip_code ?? '' }}<br>
            {{ $shipping['address'] ?? optional($profile)->address ?? '' }} 
            {{ $shipping['building'] ?? optional($profile)->building ?? '' }}
        </p>
    </div>

    <div class="buy__confirm">
        <table>
            <tr class="table__row">
                <th>商品代金</th>
                <td>¥ {{ number_format($item->price) }}</td>
            </tr>
            <tr class="table__row">
                <th>支払い方法</th>
                <td>{{ $this->selectPaymentLabel }}</td>
            </tr>
        </table>
    </div>

    <div class="buy__btn">
        <button class="form__btn-submit" type="button">購入する</button>
    </div>
</div>