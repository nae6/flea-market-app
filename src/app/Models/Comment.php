<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\User;

class Comment extends Model
{
    protected $fillable = ['item_id', 'user_id', 'content'];

    /**
     * コメント対象の商品
     */
    public function item() {
        return $this->belongsTo(Item::class);
    }

    /**
     * コメント投稿者
     */
    public function user() {
        return $this->belongsTo(User::class);
    }
}
