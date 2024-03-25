<?php

use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('/admin/home');
    });
    Route::get('/area', [AreaController::class, 'index']);
});

// Route::resource('area', \App\Http\Controllers\AreaController::class);

Route::post('/area-store', [AreaController::class, 'store']);
Route::get('/area-fetch', [AreaController::class, 'fetchData']);
Route::get('/area-fetch/{id}', [AreaController::class, 'fetchDetail']);
Route::put('/area-update/{id}', [AreaController::class, 'updateData']);
Route::delete('/area-delete/{id}', [AreaController::class, 'deleteData']);
