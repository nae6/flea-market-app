<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Http\Requests\AddressRequest;

class PurchaseController extends Controller
{
    public function index(Item $item)
    {
        return view('dashboard.purchase', compact('item'));
    }

    public function create(Item $item)
    {
        return view('dashboard.address', compact('item'));
    }

    public function confirm(AddressRequest $request, Item $item)
    {
        $shipping = $request->validated();

        session(['shipping' => $shipping]);

        return redirect()->route('buy', $item);
    }
}
