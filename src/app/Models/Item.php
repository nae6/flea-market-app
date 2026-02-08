<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Item extends Model
{
    protected $fillable = [
        'item_name',
        'image_url',
        'brand',
        'price',
        'condition',
        'description',
        'status',
        'user_id',
        'category_id',
    ];
}
