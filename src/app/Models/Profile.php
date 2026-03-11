<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'avatar_url',
        'zip_code',
        'address',
        'building',
    ];

    /**
     * users_tableと1対1リレーション
     */
    public function user() {
        return $this->belongsTo(Profile::class);
    }
}
