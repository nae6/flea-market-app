<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;

class ProfileController extends Controller
{
    /**
     * マイページの表示
     * タブの状態を取得し、購入商品または出品商品の一覧を取得
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request) {
        $activePage = $request->input('page', 'sell');

        if (!in_array($activePage, ['sell', 'buy'], true)) {
            $activePage = 'sell';
        }

        $user = Auth::user();

        if ($activePage === 'buy') {
            $query = $user->orders()
                ->whereHas('item')
                ->with('item:id,item_name,image_url,status')
                ->latest('orders.created_at');
        } else {
            $query = $user->items()
                ->select('items.id', 'items.item_name', 'items.image_url', 'items.status')
                ->latest('items.created_at');
        }

        $items = $query->get();

        $profile = $user->profile;

        return view('dashboard.mypage', compact('activePage', 'items','user', 'profile'));
    }

    /**
     * プロフィール編集画面の表示
     */
    public function edit() {
        $user = Auth::user();
        $profile = Profile::firstOrNew(['user_id' => $user->id]);

        return view('dashboard.profile', compact('user', 'profile'));
    }

    /**
     * プロフィール内容の新規作成または更新
     */
    public function update(ProfileRequest $request) {
        $user = Auth::user();
        $data = $request->validated();
        $profile = $user->profile;

        if ($request->hasFile('avatar_url')) {
            $path = $request->file('avatar_url')->store('avatars', 'public');

            if ($profile && $profile->avatar_url) {
                Storage::disk('public')->delete($profile?->avatar_url);
            }
            $data['avatar_url'] = $path;
        } else {
            unset($data['avatar_url']);
        }

        $user->profile()->updateOrCreate(['user_id' => $user->id], $data);

        return redirect()->route('mypage');
    }
}
