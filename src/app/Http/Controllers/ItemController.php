<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $activeTab = $request->get('tab', 'recommend');

        $items = Item::query()
            ->excludeOwn()
            ->keyword($keyword)
            ->select('id', 'item_name', 'image_url', 'status')
            ->latest()
            ->get();

        return view('items.index', compact('activeTab', 'items', 'keyword'));
    }

    public function show(Item $item)
    {
        $item->load('categories');

        return view('items.show', compact('item'));
    }

}
