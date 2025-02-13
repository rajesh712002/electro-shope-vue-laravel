<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminloginController;
use App\Http\Controllers\admin\DiscountCouponController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//  Category
Route::get('/category-show',[CategoryController::class,'category']);
Route::get('/category-show-all',[CategoryController::class,'categoryAll']);
Route::post('/create-category',[CategoryController::class,'storeCategory']);
Route::delete('/delete-category/{id}',[CategoryController::class,'destroyCategory']);
Route::get('/category-show/{id}',[CategoryController::class,'editCategory']);
Route::put('/update-category/{id}',[CategoryController::class,'updateCategory']);

//  SubCategory
Route::get('/subcategory-show', [CategoryController::class, 'viewSubcategory']);
Route::post('/create-subcategory', [CategoryController::class, 'storeSubcategory']);
Route::delete('/delete-subcategory/{subcategory}', [CategoryController::class, 'destroySubcategory']);
 Route::get('/subcategory-show/{subcategory}', [CategoryController::class, 'editSubcategory']);
 Route::put('/update-subcategory/{subcategory}', [CategoryController::class, 'updateSubcategory']);


 // Brand
 Route::get('/brand-show', [ProductController::class, 'brand']);
 Route::post('/create-brand', [ProductController::class, 'storeBrand']);
 Route::delete('/delete-brand/{brand}', [ProductController::class, 'destroyBrand']);
 Route::get('/brand-show/{brand}', [ProductController::class, 'editBrand']);
 Route::put('/update-brand/{id}', [ProductController::class, 'updateBrand']);


 
// //Insert Brand
// Route::get('/createbrand', [ProductController::class, 'createBrand'])->name('admin.create_brand');
// //Update Sub
// //Delete SubCategory


 // Banner
 Route::get('banner-show', [DiscountCouponController::class, 'viewBanner']);
 Route::post('create-banner', [DiscountCouponController::class, 'storeBanner']);
 Route::delete('delete-banner/{id}', [DiscountCouponController::class, 'deleteBanner']);
 Route::get('banner-show/{id}', [DiscountCouponController::class, 'editBanner']);
 Route::put('update-banners/{id}', [DiscountCouponController::class, 'updateBanner']);

 //  Coupon
 Route::get('coupon-show', [DiscountCouponController::class, 'coupons']);
 Route::post('create-coupon', [DiscountCouponController::class, 'storeCoupon']);



//  Reports
Route::get('/orders-report', [AdminloginController::class, 'viewOrders']);
Route::get('/users-report', [AdminloginController::class, 'users']);
Route::get('/feddbacks-report', [AdminloginController::class, 'viewRating']);


