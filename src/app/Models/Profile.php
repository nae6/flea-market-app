<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

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
