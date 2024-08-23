<?php


use App\Http\Middleware\ValidUser;
use App\Http\Middleware\ValidAdmin;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminloginController;
use App\Http\Controllers\user\CartController;
use App\Http\Controllers\user\CheckoutController;
use App\Http\Controllers\user\SettingController;
use App\Http\Controllers\user\ShopController;

Route::get('/', function () {
    return view('welcome');
});


//USER

Route::get('/user/login', [UserController::class, 'login'])->name('userlogin');
Route::post('/user/loginchk', [UserController::class, 'loginchk'])->name('usercheck');
Route::get('/user/deshboard', [UserController::class, 'deshboard'])->name('userdeshboard');

Route::get('/user/aboutus', [UserController::class, 'aboutUs'])->name('aboutus');
Route::get('/user/contactus', [UserController::class, 'contactUs'])->name('contactus');
Route::get('/user/privacy', [UserController::class, 'privacy'])->name('privacy');

Route::get('/user/forgotpassword', [SettingController::class, 'forgetPassword'])->name('user.forgetPassword');
Route::post('/user/processforgetfassword', [SettingController::class, 'processForgetPassword'])->name('user.processForgetPassword');
Route::get('/user/resestforgotpassword/{token?}', [SettingController::class, 'resestForgetPassword'])->name('user.resestForgetPassword');


Route::get('/register', [UserController::class, 'register'])->name('register');
Route::post('/user/store', [UserController::class, 'store'])->name('userstore');

Route::get('/user/logout', [UserController::class, 'logout'])->name('user.logout');

Route::middleware([ValidUser::class])->group(function () {

    Route::get('/user/changepassword', [SettingController::class, 'changePassword'])->name('user.changePassword');
    Route::post('/user/showchangepassword', [SettingController::class, 'showchangePassword'])->name('user.showchangePassword');

    Route::get('/user/shop/{categoryslug?}/{subcategoryslug?}', [ShopController::class, 'shop'])->name('usershop');
    Route::get('/user/viewproduct/{slug}', [ShopController::class, 'view_product'])->name('viewproduct');

    Route::get('/user/index', [UserController::class, 'index'])->name('userindex');
    
    Route::get('/user/profile', [SettingController::class, 'account'])->name('useraccount');
    Route::post('/user/changeprofile', [SettingController::class, 'changeProfile'])->name('userchangeProfile');

    //Order Process
    Route::get('/order', [SettingController::class, 'view_order'])->name('user.view_order');
    Route::get('/orderdetail/{orderId?}', [SettingController::class, 'orderDetail'])->name('user.order_detail');
    Route::delete('order/remove_order/{Id}',[SettingController::class,'remove_order'])->name('user.remove_order');

    //Cart Process
    Route::get('/cart', [CartController::class, 'index'])->name('user.index');
    Route::post('/addcart', [CartController::class, 'addToCart'])->name('user.addToCart');
    Route::put('cart/increase/{rowId}',[CartController::class,'increaseCartQty'])->name('qty.increase');
    Route::put('cart/decrease/{rowId}',[CartController::class,'decreaseCartQty'])->name('qty.decrease');
    Route::delete('cart/remove_item/{rowId}',[CartController::class,'remove_item'])->name('qty.remove_item');


    //Wishlist Process
    Route::get('/wishlist', [CartController::class, 'wishlist'])->name('user.wishlist');
    Route::post('/addwishlist', [CartController::class, 'addToWishlist'])->name('user.addToWishlist');
    Route::delete('/removewishlist/{id}',[CartController::class,'remove_wishlist'])->name('user.remove_wishlist');

    Route::delete('/moveToCart/{id}', [CartController::class, 'moveToCart'])->name('user.moveToCart');



    //Checkout

    Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('user.checkout');
    Route::post('/storecheckout', [CheckoutController::class, 'storeCheckout'])->name('user.storecheckout');



});



 //=======//==============//=====================//============================//===================================//==========================================//
//=======//==============//=====================//============================//===================================//==========================================//


//ADMIN

Route::get('/admin/login', [AdminloginController::class, 'index'])->name('admin.login');
Route::post('/admin/adminloginchk', [AdminloginController::class, 'loginchk'])->name('adminckeck');


Route::get('/admin/logout', [AdminloginController::class, 'logout'])->name('admin.logout');

//About Us
// Route::get('/admin/aboutus', [AdminloginController::class, 'aboutus'])->name('aboutus');
// Route::get('/admin/straboutus', [AdminloginController::class, 'straboutus'])->name('straboutus');

// Admin-Products
Route::middleware([ValidAdmin::class])->group(function () {
    
    Route::get('/admin/deshboard', [AdminloginController::class, 'deshboard'])->name('admin.deshboard');
    
    Route::get('/admin/changepassword', [AdminloginController::class, 'changePassword'])->name('admin.changePassword');
    Route::post('/admin/showchangepassword', [AdminloginController::class, 'showchangePassword'])->name('admin.showchangePassword');

    Route::get('/admin/page', [AdminloginController::class, 'pages'])->name('admin.pages');
    Route::get('/admin/pages', [AdminloginController::class, 'store_pages'])->name('admin.store_pages');

    Route::get('/admin/category', [CategoryController::class, 'category'])->name('admin.category');
    //Insert Category
    Route::get('/admin/createcategories', [CategoryController::class, 'create_cat'])->name('admin.create_cat');
    Route::post('/admin/categories', [CategoryController::class, 'store_cat'])->name('admin.store_cat');
    //Update Category
    Route::get('/admin/{category}/edit', [CategoryController::class, 'edit_cat'])->name('admin.edit_cat');
    Route::put('/admin/{category}', [CategoryController::class, 'update_cat'])->name('admin.update_cat');
    //Delete Category
    Route::delete('/admin/{category}', [CategoryController::class, 'destroy_cat'])->name('admin.destroy_cat');

    //================================================================================================================================================================

    Route::get('/admin/subcategory', [CategoryController::class, 'view_subcategory'])->name('admin.subcategory');
    //Insert SubCategory
    Route::get('/admin/createsubcategories', [CategoryController::class, 'create_subcat'])->name('admin.create_subcat');
    Route::post('/admin/storesubcategory', [CategoryController::class, 'store_subcat'])->name('admin.store_subcat');
    //Update SubCategory
    Route::get('/admin/updatesubcategories/{subcategory}', [CategoryController::class, 'edit_subcate'])->name('admin.edit_subcate');
    Route::put('/admin/storesubcategory/{subcategory}', [CategoryController::class, 'update_subcate'])->name('admin.update_subcate');
    //Delete SubCategory
    Route::delete('/admin/deletesubcategory/{subcategory}', [CategoryController::class, 'destroy_subcat'])->name('admin.destroy_subcat');


    Route::get('admin/getcategories', [CategoryController::class, 'getCategories']);
    Route::get('admin/getsubcategories/{id}', [CategoryController::class, 'getSubcategories']);

    //================================================================================================================================================================

    Route::get('/admin/brand', [ProductController::class, 'brand'])->name('admin.brand');
    //Insert Brand
    Route::get('/admin/createbrand', [ProductController::class, 'create_brand'])->name('admin.create_brand');
    Route::post('/admin/brands', [ProductController::class, 'store_brand'])->name('admin.store_brand');
    //Update Brand
    Route::get('/admin/editbrand/{brand}', [ProductController::class, 'edit_brand'])->name('admin.edit_brand');
    Route::put('/admin/updatebrand/{brand}', [ProductController::class, 'update_brand'])->name('admin.update_brand');
    //Delete Brand
    Route::delete('/admin/deletebrand/{brand}', [ProductController::class, 'destroy_brand'])->name('admin.destroy_brand');

    //================================================================================================================================================================

    Route::get('/admin/product', [ProductController::class, 'product'])->name('admin.product');
    //Insert Product
    Route::get('/admin/createproducts', [ProductController::class, 'create_prod'])->name('admin.create_prod');
    Route::post('/admin/products', [ProductController::class, 'store_prod'])->name('admin.store_prod');
    //Update Product
    Route::get('/admin/editproducts/{product}', [ProductController::class, 'edit_prod'])->name('admin.edit_prod');
    Route::put('/admin/updateproduct/{product}', [ProductController::class, 'update_prod'])->name('admin.update_prod');
    //Delete Product
    Route::delete('/admin/deleteproduct/{product}', [ProductController::class, 'destroy_product'])->name('admin.destroy_product');

    //================================================================================================================================================================

    //User Data
    Route::get('/admin/orders', [AdminloginController::class, 'viewOrders'])->name('admin.orders');
    Route::get('/admin/orderdetail/{id?}', [AdminloginController::class, 'viewOrderDetails'])->name('admin.orderdetail');
    Route::put('/admin/updateorderdetail/{id?}', [AdminloginController::class, 'updateUserOrder'])->name('admin.updateorderdetail');


    Route::get('/admin/users', [AdminloginController::class, 'users'])->name('admin.users');
});