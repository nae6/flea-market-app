<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;
use App\Models\Profile;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $activePage = $request->get('page', 'sell');

        if (!in_array($activePage, ['sell', 'buy'], true)) {
            $activePage = 'sell';
        }

        if ($activePage === 'sell')
        {
            $query = Item::query()
                ->select('id', 'item_name', 'image_url', 'status')
                ->where('user_id', Auth::id())
                ->latest();
        } else
        {
            $query = Auth::user()
                ->boughtItems()
                ->select(['items.id', 'items.item_name', 'items.image_url', 'items.status'])
                ->orderByDesc('orders.created_at');
        }

        $items = $query->get();
        $user = Auth()->user();

        return view('dashboard.mypage', compact('activePage', 'items', 'user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = Profile::firstOrNew(['user_id' => $user->id]);

        return view('dashboard.profile', compact('user', 'profile'));
    }
}
