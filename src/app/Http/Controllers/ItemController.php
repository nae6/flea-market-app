<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\ExhibitionRequest;
use App\Models\Category;
use App\Models\Item;


class ItemController extends Controller
{
    /**
     * トップページを表示
     * 検索キーワードとタブの状態を取得し、
     * おすすめ商品またはお気に入り商品の一覧を取得
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $activeTab = $request->get('tab', 'recommend');

        $query = Item::query()->forRecommended($keyword);

        if ($activeTab === 'mylist' && auth()->check()) {
            $query->mylist(Auth::id());
        }

        $items = $query->get();

        return view('dashboard.index', compact('activeTab', 'items', 'keyword'));
    }

    /**
     * 商品詳細画面の表示
     *
     * @param Item $item
     * @return View
     */
    public function show(Item $item)
    {
        $item->load(['categories'])->loadCount(['favorites', 'comments']);

        $isFavorited = false;

        if (auth()->check()) {
            $isFavorited = $item->favorites()
                ->where('user_id', auth()->id())
                ->exists();
        }

        return view('dashboard.show', compact('item', 'isFavorited'));
    }

    /**
     * 出品登録画面の表示
     */
    public function create()
    {
        $categories = Category::select('id', 'category_name')->get();

        return view('dashboard.exhibition', compact('categories'));
    }

    /**
     * 出品商品の登録
     */
    public function store(ExhibitionRequest $request)
    {
        $data = $request->validated();

        $categoryIds = $data['categories'];
        unset($data['categories']);

        $data['image_url'] = $request->file('image_url')->store('items','public');
        $data['status'] = 1;

        DB::transaction(function() use ($data, $categoryIds) {
            $item = Auth::user()->items()->create($data);
            $item->categories()->sync($categoryIds);
        });

        return redirect()->route('mypage');
    }

}
