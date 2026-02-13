<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PurchaseController;

/**
 * 未認証でも閲覧可能なページ
 */
Route::get('/', [ItemController::class, 'index'])
    ->name('index');
Route::get('/item/{item}', [ItemController::class, 'show'])
    ->name('items.show');

/**
 * 認証が必要なページ
 */
Route::middleware('auth')->group(function()
{
    Route::post('/item/{item}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    Route::post('/item/{item}/favorite', [FavoriteController::class, 'toggle'])
        ->name('items.favorite');


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
    Route::get('/buy/{item}', [PurchaseController::class, 'index'])
        ->name('buy');
});