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
        <select wire:model.live="selectPayment" name="payment_method" class="payment__select">
            <option value="" disabled>選択してください</option>
            <option value="konbini">コンビニ払い</option>
            <option value="card">カード支払い</option>
        </select>
    </div>

    <div class="buy__info buy__shipping">
        <div class="shipping">
            <p class="shipping__title">配送先</p>
            <a href="{{ route('address', $item) }}">変更する</a>
        </div>
        <p class="shipping-address__detail">
            〒 {{ session('shipping.zip_code') ?? optional($profile)->zip_code ?? '' }}<br>
            {{ session('shipping.address') ?? optional($profile)->address ?? '' }} 
            {{ session('shipping.building') ?? optional($profile)->building ?? '' }}
        </p>
        @error('shipping')
        <p class="form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="buy__confirm">
        <table>
            <tr class="table__row">
                <th>商品代金</th>
                <td>¥ {{ number_format($item->price) }}</td>
            </tr>
            <tr class="table__row">
                <th>支払い方法</th>
                <td>
                    {{ $this->selectPaymentLabel }}
                    @error('payment_method')
                    <p class="form__error">{{ $message }}</p>
                    @enderror
                </td>
            </tr>
        </table>
    </div>

    <form action="{{ route('checkout', $item) }}" method="POST" class="buy__btn">
        @csrf
        <input type="hidden" name="payment_method" value="{{ $selectPayment }}">
        <button class="form__btn-submit" type="submit">購入する</button>
    </form>
</div>