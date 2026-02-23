<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;

class ProfileController extends Controller
{
    public function index(Item $item)
    {
        return view('dashboard.mypage', compact('item'));
    }

    public function edit(User $user)
    {
        $user_id = auth()->user()->id;
        return view('dashboard.mypage', compact('user_id'));
    }
}
