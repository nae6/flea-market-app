<?php

use Illuminate\Support\Facades\Route;

Route::get('/mypage/index', function () {
    return view('mypage.index');
});
