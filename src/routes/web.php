<?php

use Illuminate\Support\Facades\Route;

Route::get('/items/index', function () {
    return view('items.index');
});
Route::get('/items/show', function () {
    return view('items.show');
});
Route::get('/items/sell', function () {
    return view('items.sell');
});
Route::get('/mypage/index', function () {
    return view('mypage.index');
});
Route::get('/mypage/profile', function () {
    return view('mypage/profile');
});
Route::get('/purchases/address', function () {
    return view('purchases.address');
});
Route::get('/purchases/buy', function () {
    return view('purchases.buy');
});
Route::get('/auth/register', function () {
    return view('auth.register');
});
Route::get('/auth/login', function () {
    return view('auth.login');
});