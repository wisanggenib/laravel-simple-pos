<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isAdmin;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::prefix('admin')->middleware([isAdmin::class])->group(function () {
    Route::get('/', function () {
        return view('/admin/home');
    });
    Route::get('/area', [AreaController::class, 'index']);
    Route::get('/user', function () {
        return view('/admin/user');
    });
});

// Route::resource('area', \App\Http\Controllers\AreaController::class);

//area
Route::post('/area-store', [AreaController::class, 'store']);
Route::get('/area-fetch', [AreaController::class, 'fetchData']);
Route::get('/area-fetch/{id}', [AreaController::class, 'fetchDetail']);
Route::put('/area-update/{id}', [AreaController::class, 'updateData']);
Route::delete('/area-delete/{id}', [AreaController::class, 'deleteData']);

//user 
Route::get('/user-fetch', [UserController::class, 'fetchData']);
Route::get('/user-fetch/{id}', [UserController::class, 'fetchDetail']);
Route::put('/user-update/{id}', [UserController::class, 'updateData']);
Route::delete('/user-delete/{id}', [UserController::class, 'deleteData']);
Route::post('/registration', [UserController::class, 'register']);

//auth
Route::post('/login-action', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);
