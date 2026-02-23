<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function toggle(Item $item)
    {
        $userId = auth()->id();

        $item->favorites()->toggle($userId);

        return redirect()->back();
    }
}
