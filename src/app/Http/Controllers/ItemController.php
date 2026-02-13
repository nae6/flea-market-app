<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;


class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $activeTab = $request->get('tab', 'recommend');

        $query = Item::query()->forRecommended($keyword);

        if ($activeTab === 'mylist')
        {
            $query->mylist(auth()->id());
        }

        $items = $query->get();

        return view('items.index', compact('activeTab', 'items', 'keyword'));
    }

    public function show(Item $item)
    {
        $item->load(['categories'])->loadCount(['favorites', 'comments']);

        $isFavorited = false;

        if (auth()->check())
        {
            $isFavorited = $item->favorites()
                ->where('user_id', auth()->id())
                ->exists();
        }
        return view('items.show', compact('item', 'isFavorited'));
    }

}
