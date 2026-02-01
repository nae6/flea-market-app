<?php

use Illuminate\Support\Facades\Route;

Route::get('/items/index', function () {
    return view('items.index');
});
