<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Livewire\Payments;
use App\Http\Controllers\PurchaseController;
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
    Route::get('/purchase/address/{item}', [PurchaseController::class, 'create'])
        ->name('address');
    Route::post('/purchase/address/{item}', [PurchaseController::class, 'confirm'])
        ->name('address.confirm');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store'])
        ->name('purchase.store');


    Route::get('/sell', function () {
    return view('items.sell');
    })->name('sell');
    Route::get('/mypage', function () {
        return view('mypage');
    })->name('mypage');
    Route::get('/mypage/profile', function () {
        return view('mypage.profile');
    });

});

/**
 * Stripe Webhook
 */
Route::post('/stripe/webhook', [WebhookController::class, 'handleWebhook']);
