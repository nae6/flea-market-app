<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Profile extends Model
{
    protected $fillable = [
        'user_id',
        'user_name',
        'zip_code',
        'address',
        'building',
    ];
}
