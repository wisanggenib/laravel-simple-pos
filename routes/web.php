<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CutOffController;
use App\Http\Controllers\ProductCategoryController;
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
    Route::get('/product', function () {
        return view('/admin/product');
    });
    Route::get('/product-category', function () {
        return view('/admin/product-category');
    });
    Route::get('/cut-off', function () {
        return view('/admin/cut-off');
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

//category product
Route::get('/pc-fetch', [ProductCategoryController::class, 'fetchData']);
Route::post('/pc-store', [ProductCategoryController::class, 'store']);
Route::post('/pc-update/{id}', [ProductCategoryController::class, 'updateData']);
Route::delete('/pc-delete/{id}', [ProductCategoryController::class, 'deleteData']);
Route::get('/pc-fetch/{id}', [ProductCategoryController::class, 'fetchDetail']);

//cut off
Route::get('/cutoff-fetch', [CutOffController::class, 'fetchData']);
Route::post('/cutoff-store', [CutOffController::class, 'store']);
Route::get('/cutoff-fetch/{id}', [CutOffController::class, 'fetchDetail']);
Route::delete('/cutoff-delete/{id}', [CutOffController::class, 'deleteData']);
Route::put('/cutoff-update/{id}', [CutOffController::class, 'updateData']);

//auth
Route::post('/login-action', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

//user
Route::get('/home', function () {
    return view('/home');
});
