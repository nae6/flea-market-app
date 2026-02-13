<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

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
    ];

    /**
     * relations
      */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_items', 'item_id', 'category_id');
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
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

    /**
     * exclude own items
     */
    public function scopeExcludeOwn($query)
    {
        if (Auth::check())
        {
            $query->where('user_id', '!=', Auth::id());
        }

        return $query;
    }
    /**
     * search items by keyword
     */
    public function scopeKeyword($query, ?string $keyword)
    {
        if (!empty($keyword))
        {
            $query->where('item_name', 'like', '%' . $keyword . '%');
        }

        return $query;
    }

    /**
     * scope for recommended
     */
    public function scopeForRecommended(Builder $query, ?string $keyword): Builder
    {
        return $query
            ->excludeOwn()
            ->keyword($keyword)
            ->select(['id', 'item_name', 'image_url', 'status'])
            ->latest();
    }

    /**
     * scope for mylist
     */
    public function scopeMylist(Builder $query, int $userId): Builder
    {
        return $query->whereHas('favorites',
            function (Builder $q) use ($userId)
            {
                $q->where('users.id', $userId);
            });
    }
}
