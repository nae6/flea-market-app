<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Item;

class Payments extends Component
{
    public Item $item;
    public $profile;
    public string $selectPayment = '';

    public function getSelectPaymentLabelProperty(): string
    {
        return match ($this->selectPayment) {
            'konbini' => 'コンビニ払い',
            'card' => 'カード支払い',
            default => '未選択',
        };
    }

    public function mount(Item $item): void
    {
        $this->item = $item;
        $this->profile = auth()->user()->profile;
    }

    public function render()
    {
        return view('livewire.payments')
            ->layout('layouts.common');
    }
}
