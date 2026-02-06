<?php

use Livewire\Component;

new class extends Component
{
    public $selectPayment = '' ;
};
?>

<div>
    <select wire:model="selectPayment" name="" id="">
        <option value="" selected disabled>選択してください</option>
        <option value="pay-in-store">コンビニ払い</option>
        <option value="pay-credit-card">カード支払い</option>
    </select>
</div>

<div>
    <p>支払い方法: {{ $selectPayment }}</p>
</div>