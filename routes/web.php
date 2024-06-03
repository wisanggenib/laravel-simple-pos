<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CutOffController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\isAdmin;
use App\Http\Middleware\isUser;
use Illuminate\Support\Facades\Route;


Route::middleware([isUser::class])->group(function () {
    Route::get('/', function () {
        return view('home');
    });

    Route::get('/shop', function () {
        return view('/shop');
    });
    Route::get('/shop/{id}', function () {
        return view('/shop');
    });

    Route::get('/home', function () {
        return view('/home');
    });

    Route::get('/detail-product/{id}', [ProductController::class, 'viewDetail']);

    Route::get('/cart', function () {
        return view('/cart');
    });

    Route::get('/history', function () {
        return view('/history');
    });
    Route::get('/detail-order/{id}', [OrderController::class, 'viewDetail']);
});

Route::prefix('admin')->middleware([isAdmin::class])->group(function () {
    Route::get('/', function () {
        return view('/admin/home');
    });
    Route::get('/home', function () {
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
    Route::get('/laporan-penggunaan-budget', function () {
        return view('/admin/laporan-budget');
    });
    Route::get('/laporan-vendor', function () {
        return view('/admin/laporan-vendor');
    });
    Route::get('/laporan-penjualan-barang', function () {
        return view('/admin/laporan-barang');
    });

    // Route::get('/order', function () {
    //     return view('/admin/order');
    // });
    Route::get('/order-admin', [OrderController::class, 'fetchAdmin']);
});

// Route::resource('area', \App\Http\Controllers\AreaController::class);

//area
Route::post('/area-store', [AreaController::class, 'store']);
Route::get('/area-fetch-name/{name?}', [AreaController::class, 'fetchData']);
Route::get('/area-fetch/{id}', [AreaController::class, 'fetchDetail']);
Route::put('/area-update/{id}', [AreaController::class, 'updateData']);
Route::delete('/area-delete/{id}', [AreaController::class, 'deleteData']);

//user 
Route::get('/user-fetch-name/{id?}', [UserController::class, 'fetchData']);
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
Route::get('/pc-fetch-all', [ProductCategoryController::class, 'fetchAllData']);

//cut off
Route::get('/cutoff-fetch', [CutOffController::class, 'fetchData']);
Route::post('/cutoff-store', [CutOffController::class, 'store']);
Route::get('/cutoff-fetch/{id}', [CutOffController::class, 'fetchDetail']);
Route::delete('/cutoff-delete/{id}', [CutOffController::class, 'deleteData']);
Route::put('/cutoff-update/{id}', [CutOffController::class, 'updateData']);

//product
Route::get('/product-fetch-name/{name?}', [ProductController::class, 'fetchData']);
Route::get('/product-fetch/{id}', [ProductController::class, 'fetchDetail']);
Route::post('/product-store', [ProductController::class, 'store']);
Route::post('/product-update/{id}', [ProductController::class, 'updateData']);
Route::delete('/product-delete/{id}', [ProductController::class, 'deleteData']);
Route::get('/price-range', [ProductController::class, 'priceRange']);
Route::get('/product-filter/{data}/{name?}', [ProductController::class, 'getAllProductFilter']);

//auth
Route::post('/login-action', [UserController::class, 'login']);
Route::get('/logout', [UserController::class, 'logout']);

//cart
Route::post('/add-to-chart', [ProductController::class, 'addCart']);
Route::post('/update-to-chart', [ProductController::class, 'updateCart']);
Route::get('/cart', [ProductController::class, 'showCart']);
Route::get('/delete-cart/{id}', [ProductController::class, 'deleteCart']);

//order
Route::post('/order', [OrderController::class, 'order']);
Route::get('/order-fetch', [OrderController::class, 'fetch']);
Route::get('/order-fetch/{id}', [OrderController::class, 'fetchDetail']);
Route::post('/kirim-barang/{id}', [OrderController::class, 'kirimBarang']);
Route::post('/tolak-barang/{id}', [OrderController::class, 'tolakBarang']);
Route::post('/terima-barang/{id}', [OrderController::class, 'terimaBarang']);
Route::post('/proses-barang/{id}', [OrderController::class, 'prosesBarang']);
Route::post('/update-status-barang/{id}', [OrderController::class, 'updateStatusBarang']);
Route::post('/kirim-ulang/{id}', [OrderController::class, 'kirimUlang']);


//dashboard
Route::get('/dashboard-fetch-product/{filter}', [ProductController::class, 'dashboardProduct']);
Route::get('/dashboard-fetch-product-minus', [ProductController::class, 'fetchMinus']);
Route::get('/dashboard-fetch-vendor', [ProductController::class, 'dashboardVendor']);
Route::get('/dashboard-fetch-budget', [ProductController::class, 'dashboardBudget']);
Route::get('/cart-fetch-vendor', [ProductController::class, 'cartVendor']);
Route::get('/cart-fetch-budget', [ProductController::class, 'cartBudget']);

//export excel
Route::get('/export-excel', [ProductController::class, 'exportExcel']);
Route::get('/export-excel-product', [ProductController::class, 'exportExcelProduct']);
Route::get('/export-excel-vendor', [ProductController::class, 'exportExcelVendor']);
Route::get('/export-excel-budget', [ProductController::class, 'exportExcelBudget']);
Route::get('/export-excel-home', [ProductController::class, 'exportExcelHome']);

//login
Route::get('/login', function () {
    return view('login');
});
