<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Condition;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'image_url',
        'brand',
        'price',
        'condition_id',
        'description',
        'status',
        'user_id',
    ];

    /**
     * users_tableとの1対多リレーション
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * categories_tableとの多対多リレーション
     */
    public function categories() {
        return $this->belongsToMany(Category::class, 'category_item', 'item_id', 'category_id');
    }

    /**
     * conditions_tableとの1対1リレーション
     */
    public function condition() {
        return $this->belongsTo(condition::class);
    }

    /**
     * users_tableとfavorites_tableを介した多対多リレーション
     */
    public function favorites() {
        return $this->belongsToMany(User::class, 'favorites', 'item_id', 'user_id')->withTimestamps();
    }

    /**
     * comments_tableとの1対多リレーション
     */
    public function comments() {
        return $this->hasMany(Comment::class);
    }

    /**
     * orders_tableとの1対1リレーション
     */
    public function order() {
        return $this->hasOne(Order::class);
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
