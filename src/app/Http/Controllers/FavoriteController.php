<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class FavoriteController extends Controller
{
    public function toggle(Item $item)
    {
        $userId = auth()->id();

        $item->favorites()->toggle($userId);

        return redirect()->back();
    }
}
