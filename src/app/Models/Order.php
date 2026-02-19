<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'payment_method',
        'zip_code',
        'address',
        'building',
    ];
}
