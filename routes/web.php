<?php

use App\Http\Middleware\ValidAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminloginController;
use App\Http\Middleware\ValidUser;

Route::get('/', function () {
    return view('welcome');
});


//USER

Route::get('/user/login', [UserController::class, 'login'])->name('userlogin');
Route::post('/user/loginchk', [UserController::class, 'loginchk'])->name('usercheck');
Route::get('/user/deshboard', [UserController::class, 'deshboard'])->name('userdeshboard');

Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');

Route::middleware([ValidUser::class])->group(function () {
    
    Route::get('/user/index', [UserController::class, 'index'])->name('userindex');
    Route::get('/user/account', [UserController::class, 'account'])->name('useraccount');

    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/user/store', [UserController::class, 'store'])->name('userstore');

    //User Product Process
    Route::get('/cart', [UserController::class, 'view_cart'])->name('user.view_cart');
    Route::get('/order', [UserController::class, 'view_order'])->name('user.view_order');
    Route::get('/wishlist', [UserController::class, 'wishlist'])->name('user.wishlist');
});


//ADMIN

Route::get('/admin/login', [AdminloginController::class, 'index'])->name('admin.login');
Route::post('/admin/adminloginchk', [AdminloginController::class, 'loginchk'])->name('adminckeck');

Route::get('/admin/logout', [AdminloginController::class, 'logout'])->name('admin.logout');



// Admin-Products
Route::middleware([ValidAdmin::class])->group(function () {

    Route::get('/admin/deshboard', [AdminloginController::class, 'deshboard'])->name('admin.deshboard');

    Route::get('/admin/page', [AdminloginController::class, 'pages'])->name('admin.pages');
    Route::get('/admin/pages', [AdminloginController::class, 'store_pages'])->name('admin.store_pages');

    Route::get('/admin/category', [CategoryController::class, 'category'])->name('admin.category');
    Route::get('/admin/createcategories', [CategoryController::class, 'create_cat'])->name('admin.create_cat');
    Route::post('/admin/categories', [CategoryController::class, 'store_cat'])->name('admin.store_cat');

    Route::get('/admin/subcategory', [CategoryController::class, 'view_subcategory'])->name('admin.subcategory');
    Route::get('/admin/createsubcategories', [CategoryController::class, 'create_subcat'])->name('admin.create_subcat');
    Route::post('/admin/storesubcategory', [CategoryController::class, 'store_subcat'])->name('admin.store_subcat');

    Route::get('/admin/product', [ProductController::class, 'product'])->name('admin.product');
    Route::get('/admin/createproducts', [ProductController::class, 'create_prod'])->name('admin.create_prod');
    Route::post('/admin/products', [ProductController::class, 'store_prod'])->name('admin.store_prod');

    Route::get('/admin/brand', [ProductController::class, 'brand'])->name('admin.brand');
    Route::get('/admin/createbrand', [ProductController::class, 'create_brand'])->name('admin.create_brand');
    Route::post('/admin/brands', [ProductController::class, 'store_brand'])->name('admin.store_brand');


    //User Data
    Route::get('/admin/users', [AdminloginController::class, 'users'])->name('admin.users');
    Route::get('/admin/orders', [AdminloginController::class, 'orders'])->name('admin.orders');
});
