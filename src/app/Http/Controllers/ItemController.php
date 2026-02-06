<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'recommend');
        return view('items.index', compact('activeTab'));
    }

}
