<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class FavoriteController extends Controller
{
    /**
     * いいねの切り替え
     *
     * @param Item $item
     * @return RedirectResponse
     */
    public function toggle(Item $item): RedirectResponse
    {
        $item->favorites()->toggle(Auth::id());

        return redirect()->back();
    }
}
