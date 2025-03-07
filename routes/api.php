<?php

use Illuminate\Http\Request;
use App\Http\Middleware\ValidAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\PaypalController;
use App\Http\Controllers\BraintreeController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\ShopController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\user\SettingController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\user\CheckoutController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminloginController;
use App\Http\Controllers\Auth\AuthenticationController;
use App\Http\Controllers\admin\DiscountCouponController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return response()->json(['user' => $request->user()]);
// });

// Route::get('/test-session', [CheckoutController::class, 'testSession']);

// Route::get('/forgot-password', [SettingController::class, 'forgetPassword']);
Route::post('/user/forgot-password', [SettingController::class, 'processForgetPassword']);
Route::get('/resest-forgot-password/{token?}', [SettingController::class, 'resestForgetPassword']);
Route::post('/resest-forgot-password-email', [SettingController::class, 'processForgotPasswordEmail']);


//Stripe
Route::post('stripe', [StripePaymentController::class, 'stripe']);
Route::get('successs', [StripePaymentController::class, 'success']);
Route::get('cancell',  [StripePaymentController::class, 'cancel']);
Route::post('refund', [StripePaymentController::class, 'refund']);


//Paypal
Route::post('paypal', [PaypalController::class, 'paypal']);
Route::get('success', [PaypalController::class, 'success']);
Route::get('cancel', [PaypalController::class, 'cancel']);
Route::post('paypal/refund/{id}', [PayPalController::class, 'refund']);


//Braintree
Route::get('/braintree', [BraintreeController::class, 'braintreeCard']);
Route::post('braintree/store', [BraintreeController::class, 'braintree']);
Route::post('braintree/refund/{id}', [BraintreeController::class, 'refund']);

Route::middleware(['web'])->group(function () {
  Route::post('/store-checkout-data', [CheckoutController::class, 'storeCheckoutData']);
  Route::get('/get-checkout-data', [CheckoutController::class, 'getCheckoutData']);
});
//Checkout
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::post('/checkout', [CheckoutController::class, 'storeCheckout']);

Route::middleware('auth:sanctum')->get('/valid-user', [AuthenticationController::class, 'getLoginUser']);
Route::get('/user-logout', [AuthenticationController::class, 'userLogout']);
Route::post('/user-login', [AuthenticationController::class, 'userLoginCheck']);
Route::post('/user-register', [UserController::class, 'storeRegister']);

Route::post('/change-password', [SettingController::class, 'showchangePassword']);

Route::get('/cart', [CartController::class, 'index']);
Route::post('/add-cart', [CartController::class, 'addToCart']);
Route::put('/cart/increase/{rowId}', [CartController::class, 'increaseCartQty']);
Route::put('/cart/decrease/{rowId}', [CartController::class, 'decreaseCartQty']);
Route::delete('/cart/remove_item/{rowId}', [CartController::class, 'remove_item']);

Route::post('/apply_coupon', [CheckoutController::class, 'applyCoupon']);
Route::post('/remove_coupon', [DiscountCouponController::class, 'removeCoupon']);
Route::get('/get_coupons', [DiscountCouponController::class, 'getCoupons']);


Route::get('/get-profile', [SettingController::class, 'account']);
Route::post('/change-profile', [SettingController::class, 'changeProfile']);

Route::get('/wishlist', [CartController::class, 'wishlist']);
Route::post('/addwishlist', [CartController::class, 'addToWishlist']);
Route::delete('/remove-wishlist/{id}', [CartController::class, 'remove_wishlist']);

Route::delete('/moveToCart/{id}', [CartController::class, 'moveToCart']);

Route::get('/order', [SettingController::class, 'view_order']);
Route::get('/order-detail/{orderId?}', [SettingController::class, 'orderDetail']);
Route::delete('/order/remove_order/{Id}', [SettingController::class, 'remove_order']);

Route::get('/shop/{categoryslug?}/{subcategoryslug?}', [ShopController::class, 'shop']);
Route::get('/view-product/{slug}', [ShopController::class, 'view_product']);

//Shopping
Route::get('/shop/{categoryslug?}/{subcategoryslug?}', [ShopController::class, 'shop']);
Route::get('/view-product/{slug}', [ShopController::class, 'view_product']);

Route::post('/save-rating/{id?}', [ShopController::class, 'saveRating']);

//========================================================================================================================


Route::post('/admin-login', [AuthenticationController::class, 'adminLogincheck']);

// Route::middleware([ValidAdmin::class])->group(function () {
Route::put('/admin/change-password', [AdminloginController::class, 'showchangePassword']);
Route::get('/admin/logout', [AuthenticationController::class, 'adminLogout']);


Route::get('/deshboard', [AdminloginController::class, 'getDashboardData']);

//  Category
Route::get('/get-category', [CategoryController::class, 'getCategory']);
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

Route::get('/get-product', [ProductController::class, 'getproduct']);
Route::get('/product-show', [ProductController::class, 'product']);
Route::get('/show-data', [ProductController::class, 'showData']);

Route::post('/create-products', [ProductController::class, 'storeProduct']);
Route::delete('/delete-products/{product}', [ProductController::class, 'destroyProduct']);
Route::get('/product-show/{product}', [ProductController::class, 'editProduct']);
Route::put('/update-product/{product}', [ProductController::class, 'updateProduct']);

Route::post('/images',  [ProductController::class, 'storeImage']);
Route::post('/update/images', [ProductController::class, 'updateImages']);
Route::delete('/delete/images', [ProductController::class, 'destroyProductImages']);

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
// });
