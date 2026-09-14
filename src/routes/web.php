<?php

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ItemController;

/**
 * 未認証でも閲覧可能なページ
 */
Route::get('/', [ItemController::class, 'index'])
    ->name('index');
Route::get('/item/{item}', [ItemController::class, 'show'])
    ->name('items.show');

/**
 * メール認証用の設定
 */
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('profile.edit');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/**
 * 認証が必要なページ
 */
Route::middleware(['auth'])->group(function()
{
    Route::post('/item/{item}/comments', [CommentController::class, 'store'])
        ->name('comments.store');
    Route::post('/item/{item}/favorite', [FavoriteController::class, 'toggle'])
        ->name('items.favorite');

    Route::get('/sell', [ItemController::class, 'create'])
        ->name('sell');
    Route::post('/sell', [ItemController::class, 'store'])
        ->name('sell.store');

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
    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
});
