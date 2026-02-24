<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $activePage = $request->get('page', 'sell');

        if (!in_array($activePage, ['sell', 'buy'], true))
        {
            $activePage = 'sell';
        }

        if ($activeTab === 'buy')
            {
                $query = Auth::user()
                    ->boughtItems()
                    ->select('items.id', 'items.item_name', 'items.image_url', 'items.status')
                    ->orderByDesc('orders.created_at');
            } else
            {
                $query = Auth::user()
                    ->items('id', 'item_name', 'image_url', 'status')
                    ->latest('items.created_at');
            }

            $items = $query->get();

        return view('dashboard.mypage', compact('activePage', 'items'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;
        return view('dashboard.profile', compact('user', 'profile'));
    }
}
