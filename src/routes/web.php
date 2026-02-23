<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Livewire\Payments;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ProfileController;
use Laravel\Cashier\Http\Controllers\WebhookController;

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

    Route::get('/purchase/{item}', [PurchaseController::class, 'index'])
        ->name('buy');
    Route::post('/purchase/{item}', [PurchaseController::class, 'checkout'])
        ->name('checkout');

    Route::get('/purchase/address/{item}', [PurchaseController::class, 'create'])
        ->name('address');
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'confirm'])
        ->name('address.confirm');

    Route::get('/mypage', [ProfileController::class, 'index'])
        ->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::post('/mypage/profile', [ProfileController::class, 'store'])
        ->name('profile.store');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::get('/sell', function () {
    return view('items.sell');
    })->name('sell');

});
