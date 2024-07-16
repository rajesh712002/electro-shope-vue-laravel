<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminloginController;

Route::get('/', function () {
    return view('welcome');
});


//USER

Route::get('/user/login', [UserController::class, 'login'])->name('userlogin');
Route::post('/user/loginchk', [UserController::class, 'loginchk'])->name('usercheck');

Route::get('/user/deshboard', [UserController::class, 'deshboard'])->name('userdeshboard');


Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/user/store', [UserController::class, 'store'])->name('userstore');


//ADMIN

Route::get('/admin/login', [AdminloginController::class, 'index'])->name('admin.login');
Route::post('/admin/adminloginchk', [AdminloginController::class, 'loginchk'])->name('adminckeck');

Route::get('/admin/deshboard', [AdminloginController::class, 'deshboard'])->name('admin.deshboard');

Route::get('/admin/page', [AdminloginController::class, 'pages'])->name('admin.pages');
Route::get('/admin/pages', [AdminloginController::class, 'store_pages'])->name('admin.store_pages');

Route::get('/admin/logout', [AdminloginController::class, 'logout'])->name('admin.logout');


//User Data
Route::get('/admin/users', [AdminloginController::class, 'users'])->name('admin.users');
Route::get('/admin/orders', [AdminloginController::class, 'orders'])->name('admin.orders');

// Admin-Products

Route::get('/admin/category', [CategoryController::class, 'category'])->name('admin.category');
Route::get('/admin/categories', [CategoryController::class, 'store_cat'])->name('admin.store_cat');

Route::get('/admin/subcategory', [CategoryController::class, 'subcategory'])->name('admin.subcategory');
Route::get('/admin/createsubcategory', [CategoryController::class, 'store_subcat'])->name('admin.store_subcat');

Route::get('/admin/product', [ProductController::class, 'product'])->name('admin.product');
Route::get('/admin/products', [ProductController::class, 'store_prod'])->name('admin.store_prod');

Route::get('/admin/brand', [ProductController::class, 'brand'])->name('admin.brand');
Route::get('/admin/brands', [ProductController::class, 'store_brand'])->name('admin.store_brand');
