<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Category extends Model
{
    protected $fillable = ['category_name'];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

}
