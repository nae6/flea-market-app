<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

/**
 * 未認証でも閲覧可能なページ
 */
Route::get('/', [ItemController::class, 'index'])
    ->name('index');
Route::get('/item/{item}', [ItemController::class, 'show'])
    ->name('show');

/**
 * 認証が必要なページ
 */
Route::middleware('auth')->group(function()
{
    Route::get('/sell', function () {
    return view('items.sell');
    })->name('sell');

    Route::get('/mypage', function () {
        return view('mypage');
    })->name('mypage');
    Route::get('/mypage/profile', function () {
        return view('mypage.profile');
    });

    Route::get('/purchases/address', function () {
        return view('purchases.address');
    });
    Route::get('/purchases/buy', function () {
        return view('purchases.buy');
    });
});