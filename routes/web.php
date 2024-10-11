<?php


use App\Http\Middleware\ValidUser;
use App\Http\Middleware\ValidAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\HomeController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/orderEmail', function () {
//     sendEmail(7);
// });


//USER

Route::get('/', action: [UserController::class, 'index'])->name('userindex');

Route::get('/testing', function () {
    return view('user.order.testing');
});

Route::get('/test', function () {
    return view('user.order.test');
});

Route::prefix('user')->group(function () {

    Route::get('/login', [AuthenticationController::class, 'userLogin'])->name('userlogin');
    Route::post('/login', [AuthenticationController::class, 'userLoginCheck'])->name('usercheck');
    // Route::get('/dashboard', [UserController::class, 'dashboard'])->name('userdeshboard');

    Route::get('/about-us', [UserController::class, 'aboutUs'])->name('aboutus');
    Route::get('/contact-us', [UserController::class, 'contactUs'])->name('contactus');
    Route::get('/privacy', [UserController::class, 'privacy'])->name('privacy');

    Route::get('/forgot-password', [SettingController::class, 'forgetPassword'])->name('user.forgetPassword');
    Route::post('/forgot-password', [SettingController::class, 'processForgetPassword'])->name('user.processForgetPassword');
    Route::get('/resest-forgot-password/{token?}', [SettingController::class, 'resestForgetPassword'])->name('user.resestForgetPassword');
    Route::post('/resest-forgot-password-email', [SettingController::class, 'processForgotPasswordEmail'])->name('user.processForgotPasswordEmail');

    //Shopping
    Route::get('/shop/{categoryslug?}/{subcategoryslug?}', [ShopController::class, 'shop'])->name('usershop');
    Route::get('/view-product/{slug}', [ShopController::class, 'view_product'])->name('viewproduct');

    Route::post('/save-rating/{id?}', [ShopController::class, 'saveRating'])->name('usersaveRating');

    //Cart Process
    Route::get('/cart', [CartController::class, 'index'])->name('user.index');
    Route::post('/addcart', [CartController::class, 'addToCart'])->name('user.addToCart');
    Route::put('/cart/increase/{rowId}', [CartController::class, 'increaseCartQty'])->name('qty.increase');
    Route::put('/cart/decrease/{rowId}', [CartController::class, 'decreaseCartQty'])->name('qty.decrease');
    Route::delete('/cart/remove_item/{rowId}', [CartController::class, 'remove_item'])->name('qty.remove_item');

    //Guest Cart Process
    Route::post('/guest/cart/qty-decrease', [CartController::class, 'decreaseQtyGuest'])->name('guest.cart.qty.decrease');
    Route::post('/guest/cart/qty-increase', [CartController::class, 'increaseQtyGuest'])->name('guest.cart.qty.increase');
    Route::post('/guest/cart/remove', [CartController::class, 'removeItemGuest'])->name('guest.cart.remove');

    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'storeRegister'])->name('userstore');

    Route::get('/logout', [AuthenticationController::class, 'userLogout'])->name('user.logout');
});

//=======//==============//====================

//  ==>  Payment Integration

//Stripe
Route::post('stripe', [StripePaymentController::class, 'stripe'])->name('stripe');
Route::get('successs', [StripePaymentController::class, 'success'])->name('successs');
Route::get('cancell', [StripePaymentController::class, 'cancel'])->name('cancell');

//Paypal
Route::post('paypal', [PaypalController::class, 'paypal'])->name('paypal');
Route::get('success', [PaypalController::class, 'success'])->name('success');
Route::get('cancel', [PaypalController::class, 'cancel'])->name('cancel');

//Braintree
Route::get('/braintree', [BraintreeController::class, 'braintreeCard'])->name('braintreeCard');
Route::post('braintree/store', [BraintreeController::class, 'braintree'])->name('braintree');

Route::middleware([ValidUser::class])->group(function (): void {
    Route::prefix('user')->group(function () {

        Route::get('/change-password', [SettingController::class, 'changePassword'])->name('user.changePassword');
        Route::post('/change-password', [SettingController::class, 'showchangePassword'])->name('user.showchangePassword');

        Route::get('/profile', [SettingController::class, 'account'])->name('useraccount');
        Route::post('/change-profile', [SettingController::class, 'changeProfile'])->name('userchangeProfile');

        //Order Process
        Route::get('/order', [SettingController::class, 'view_order'])->name('user.view_order');
        Route::get('/order-detail/{orderId?}', [SettingController::class, 'orderDetail'])->name('user.order_detail');
        Route::delete('/order/remove_order/{Id}', [SettingController::class, 'remove_order'])->name('user.remove_order');

        //Wishlist Process
        Route::get('/wishlist', [CartController::class, 'wishlist'])->name('user.wishlist');
        Route::post('/addwishlist', [CartController::class, 'addToWishlist'])->name('user.addToWishlist');
        Route::delete('/remove-wishlist/{id}', [CartController::class, 'remove_wishlist'])->name('user.remove_wishlist');

        Route::delete('/moveToCart/{id}', [CartController::class, 'moveToCart'])->name('user.moveToCart');

        //Checkout
        Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('user.checkout');
        Route::post('/checkout', [CheckoutController::class, 'storeCheckout'])->name('user.storecheckout');

        Route::post('/apply_coupon', [DiscountCouponController::class, 'applyCoupon'])->name('apply_coupon');

        Route::get('/orderEmail/{id}', [CheckoutController::class, 'orderEmail']);
    });
});

//=======//==============//=====================//============================//===================================//==========================================//
//=======//==============//=====================//============================//===================================//==========================================//

//ADMIN

Route::get('/admin/login', [AuthenticationController::class, 'adminLogin'])->name('admin.login');
Route::post('/admin-login', [AuthenticationController::class, 'adminLogincheck'])->name('adminckeck');

Route::get('/admin/logout', [AuthenticationController::class, 'adminLogout'])->name('admin.logout');

// Admin-Products
Route::middleware([ValidAdmin::class])->group(function () {
    Route::prefix('admin')->group(function (): void {

        Route::get(uri: '/dashboard', action: [AdminloginController::class, 'deshboard'])->name(name: 'admin.deshboard');

        Route::get('/view-rating', [AdminloginController::class, 'viewRating'])->name('admin.viewRating');

        Route::get('/change-password', [AdminloginController::class, 'changePassword'])->name('admin.changePassword');
        Route::post('/change-password', [AdminloginController::class, 'showchangePassword'])->name('admin.showchangePassword');

        Route::get('/page', [AdminloginController::class, 'pages'])->name('admin.pages');
        Route::get('/pages', [AdminloginController::class, 'store_pages'])->name('admin.store_pages');

        Route::get('/category', [CategoryController::class, 'category'])->name('admin.category');
        //Insert Category
        Route::get('/create-categories', [CategoryController::class, 'createCategory'])->name('admin.create_cat');
        Route::post('/categories', [CategoryController::class, 'storeCategory'])->name('admin.store_cat');
        //Update Category
        Route::get('/{category}/edit', [CategoryController::class, 'editCategory'])->name('admin.edit_cat');
        Route::put('/{category}', [CategoryController::class, 'updateCategory'])->name('admin.update_cat');
        //Delete Category
        Route::delete('/{category}', [CategoryController::class, 'destroyCategory'])->name('admin.destroy_cat');

        //================================================================================================================================================================

        Route::get('/subcategory', [CategoryController::class, 'viewSubcategory'])->name('admin.subcategory');
        //Insert SubCategory
        Route::get('/create-subcategories', [CategoryController::class, 'createSubcategory'])->name('admin.create_subcat');
        Route::post('/subcategories', [CategoryController::class, 'storeSubcategory'])->name('admin.store_subcat');
        //Update SubCategory
        Route::get('/update-subcategories/{subcategory}', [CategoryController::class, 'editSubcategory'])->name('admin.edit_subcate');
        Route::put('/subcategories/{subcategory}', [CategoryController::class, 'updateSubcategory'])->name('admin.update_subcate');
        //Delete SubCategory
        Route::delete('/delete-subcategory/{subcategory}', [CategoryController::class, 'destroySubcategory'])->name('admin.destroy_subcat');

        Route::get('admin/get-categories', [CategoryController::class, 'getCategories']);
        Route::get('admin/get-subcategories/{id}', [CategoryController::class, 'getSubcategories']);

        //================================================================================================================================================================

        Route::get('/brand', [ProductController::class, 'brand'])->name('admin.brand');
        //Insert Brand
        Route::get('/createbrand', [ProductController::class, 'createBrand'])->name('admin.create_brand');
        Route::post('/brands', [ProductController::class, 'storeBrand'])->name('admin.store_brand');
        //Update Brand
        Route::get('/edit-brand/{brand}', [ProductController::class, 'editBrand'])->name('admin.edit_brand');
        Route::put('/update-brand/{brand}', [ProductController::class, 'updateBrand'])->name('admin.update_brand');
        //Delete Brand
        Route::delete('/delete-brand/{brand}', [ProductController::class, 'destroyBrand'])->name('admin.destroy_brand');

        //================================================================================================================================================================

        Route::get('/product', [ProductController::class, 'product'])->name('admin.product');
        //Insert Product
        Route::get('/create-products', [ProductController::class, 'createProduct'])->name('admin.create_prod');
        Route::post('/products', [ProductController::class, 'storeProduct'])->name('admin.store_prod');
        //Update Product
        Route::get('/edit-products/{product}', [ProductController::class, 'editProduct'])->name('admin.edit_prod');
        Route::put('/update-product/{product}', [ProductController::class, 'updateProduct'])->name('admin.update_prod');
        //Delete Product
        Route::delete('/delete-product/{product}', [ProductController::class, 'destroyProduct'])->name('admin.destroy_product');

        //================================================================================================================================================================
        //Coupon Code
        Route::get('coupon', [DiscountCouponController::class, 'coupons'])->name('admin.coupons');
        //Insert Coupon Code
        Route::get('coupon-create', [DiscountCouponController::class, 'createCoupon'])->name('admin.couponCreate');
        Route::post('coupon-store', [DiscountCouponController::class, 'storeCoupon'])->name('admin.couponStore');
        //Update Coupon Code
        Route::get('coupon-edit/{id}', [DiscountCouponController::class, 'editCoupon'])->name('admin.couponEdit');
        Route::put('coupon-update/{id}', [DiscountCouponController::class, 'updateCoupon'])->name('admin.couponUpdate');
        //Delete Coupon Code
        Route::delete('coupon-delete/{id}', [DiscountCouponController::class, 'deleteCoupon'])->name('admin.couponDelete');

        //================================================================================================================================================================

        //User Data
        Route::get('/orders', [AdminloginController::class, 'viewOrders'])->name('admin.orders');
        Route::get('/order-detail/{id?}', [AdminloginController::class, 'viewOrderDetails'])->name('admin.orderdetail');
        Route::put('/update-order-detail/{id?}', [AdminloginController::class, 'updateUserOrder'])->name('admin.updateorderdetail');

        Route::post('/send-Invoice-Email/{id?}', [AdminloginController::class, 'sendIvoiceToCustomer'])->name('admin.sendInvoiceEmail');

        Route::get('/pendingd-order', [AdminloginController::class, 'viewPendingOrders'])->name('admin.pendingdorder');
        Route::get('/processing-order', [AdminloginController::class, 'viewProcessingOrders'])->name('admin.processingorder');
        Route::get('/cancle-order', [AdminloginController::class, 'viewCancleOrders'])->name('admin.cancleorder');
        Route::get('/delivered-order', [AdminloginController::class, 'viewDeliveredOrders'])->name('admin.deliveredorder');

        Route::get('/users', [AdminloginController::class, 'users'])->name('admin.users');
    });
});
