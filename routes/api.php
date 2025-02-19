<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\BraintreeController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminloginController;
use App\Http\Controllers\admin\DiscountCouponController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/deshboard', [AdminloginController::class, 'getDashboardData']);

//  Category
Route::get('/category-show', [CategoryController::class, 'category']);
Route::get('/category-show-all', [CategoryController::class, 'categoryAll']);
Route::post('/create-category', [CategoryController::class, 'storeCategory']);
Route::delete('/delete-category/{id}', [CategoryController::class, 'destroyCategory']);
Route::get('/category-show/{id}', [CategoryController::class, 'editCategory']);
Route::put('/update-category/{id}', [CategoryController::class, 'updateCategory']);

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

//  Products
Route::get('/get-subcategories/{id}', [CategoryController::class, 'getSubcategories']);
Route::get('/product-show', [ProductController::class, 'product']);
Route::get('/show-data', [ProductController::class, 'showData']);

Route::post('/create-products', [ProductController::class, 'storeProduct']);
Route::delete('/delete-products/{product}', [ProductController::class, 'destroyProduct']);
Route::get('/product-show/{product}', [ProductController::class, 'editProduct']);
Route::put('/update-product/{product}', [ProductController::class, 'updateProduct']);

Route::post('/images',  [ProductController::class, 'storeImage']);
Route::post('/update/images',[ProductController::class,'updateImages']);
Route::delete('/delete/images',[ProductController::class,'destroyProductImages']);

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
Route::get('coupon-show/{id}', [DiscountCouponController::class, 'editCoupon']);
Route::put('update-coupon/{id}', [DiscountCouponController::class, 'updateCoupon']);
Route::delete('delete-coupon/{id}', [DiscountCouponController::class, 'deleteCoupon']);


//  Reports
Route::get('/orders-report', [AdminloginController::class, 'viewOrders']);
Route::get('/order-detail/{id?}', [AdminloginController::class, 'viewOrderDetails']);
Route::post('/send-Invoice-Email/{id?}', [AdminloginController::class, 'sendIvoiceToCustomer']);
Route::put('/update-order-detail/{id?}', [AdminloginController::class, 'updateUserOrder']);

Route::get('/users-report', [AdminloginController::class, 'users']);
Route::get('/feddbacks-report', [AdminloginController::class, 'viewRating']);

//  ==>  Export Ecxel File
Route::get('users-excel', [ExportController::class, 'usersExcel']);
Route::get('orders-excel', [ExportController::class, 'ordersExcel']);
Route::get('ratings-excel', [ExportController::class, 'ratingsExcel']);

//Refund
Route::post('stripe-refund/{id}', [StripePaymentController::class, 'refund']);
Route::post('braintree-refund/{id}', [BraintreeController::class, 'refund']);
Route::post('paypal-refund/{id}', [PayPalController::class, 'refund']);
