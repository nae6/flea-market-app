<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;

class Condition extends Model
{
    use HasFactory;

    protected $fillable = ['condition_name'];

    /**
     * items_tableとの1対1リレーション
     */
    public function item() {
        return $this->hasOne(Item::class);
    }
}
