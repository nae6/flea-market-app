<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::get('/', [ItemController::class, 'index'])
    ->name('index');

Route::get('/items/show', function () {
    return view('items.show');
});
Route::get('/items/sell', function () {
    return view('items.sell');
})->name('sell');


Route::get('/mypage/index', function () {
    return view('mypage.index');
})->name('mypage');
Route::get('/mypage/profile', function () {
    return view('mypage/profile');
});


Route::get('/purchases/address', function () {
    return view('purchases.address');
});
Route::get('/purchases/buy', function () {
    return view('purchases.buy');
});