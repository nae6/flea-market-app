<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CommentRequest;
use App\Models\Item;

class CommentController extends Controller
{
    /**
     * コメントの登録
     *
     * @param CommentRequest $request
     * @param Item $item
     * @return RedirectResponse
     */
    public function store(CommentRequest $request, Item $item)
    {
        $validated = $request->validated();

        $item->comments()->create([
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return redirect()->route('items.show', $item);
    }

}
