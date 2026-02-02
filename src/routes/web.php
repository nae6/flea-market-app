<?php

use Illuminate\Support\Facades\Route;

Route::get('/items/show', function () {
    return view('items.show');
});
