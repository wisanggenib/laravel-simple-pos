<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('/admin/home');
    });
});
