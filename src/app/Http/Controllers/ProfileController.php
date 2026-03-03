<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
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

        if ($activePage === 'buy') {
            $query = Auth::user()
                ->boughtItems()
                ->select('items.id', 'items.item_name', 'items.image_url', 'items.status')
                ->orderByDesc('orders.created_at');
        } else {
            $query = Auth::user()
                ->items('id', 'item_name', 'image_url', 'status')
                ->latest('items.created_at');
        }

        $items = $query->get();
        $user = Auth::user();

        return view('dashboard.mypage', compact('activePage', 'items', 'user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = Profile::firstOrNew(['user_id' => $user->id]);

        return view('dashboard.profile', compact('user', 'profile'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->validated();

        $profile = $user->profile;

        if ($request->hasFile('avatar_url'))
        {
            $path = $request->file('avatar_url')->store('avatars', 'public');

            if ($profile && $profile->avatar_url)
            {
                Storage::disk('public')->delete($profile?->avatar_url);
            }
            $data[avatar_url] = $path;
        } else {
            unset($data['avatar_url']);
        }

        $user->profile()->updateOrCreate([], $data);

        return redirect()->route('mypage');
    }
}
