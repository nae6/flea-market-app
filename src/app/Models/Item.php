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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * settings for condition
     */
    const CONDITION_GOOD = 1;
    const CONDITION_FINE = 2;
    const CONDITION_USED = 3;
    const CONDITION_BAD  = 4;

    public static function conditionLabels()
    {
        return [
            self::CONDITION_GOOD => '良好',
            self::CONDITION_FINE => '目立った傷や汚れなし',
            self::CONDITION_USED => 'やや傷や汚れあり',
            self::CONDITION_BAD  => '状態が悪い',
        ];
    }

    public function getConditionLabelAttribute()
    {
        return self::conditionLabels()[$this->condition] ?? '';
    }


    /**
     * settings for status
     */
    const STATUS_SELLING = 1;
    const STATUS_SOLD = 2;

    public static function statusLabels()
    {
        return [
            self::STATUS_SELLING => 'selling',
            self::STATUS_SOLD => 'sold',
        ];
    }

    public function getStatusLabelAttribute()
    {
        return self::statusLabels()[$this->status] ?? '';
    }
}
