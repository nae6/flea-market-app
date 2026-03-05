<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\User;

class Order extends Model
{
    protected $fillable = [
        'buyer_id',
        'item_id',
        'payment_method',
        'stripe_checkout_session_id',
        'stripe_payment_intent_id',
        'amount',
        'zip_code',
        'address',
        'building',
        'status',
    ];

    /**
     * relations
     */
    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function item()
    {
        return $this->hasTo(Item::class);
    }
}
