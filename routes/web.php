<?php

use App\Http\Controllers\admin\AdminloginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//USER

Route::get('/user/login',[UserController::class,'login'])->name('userlogin');
Route::get('/user/loginchk',[UserController::class,'loginchk'])->name('usercheck');

Route::get('/user/deshboard',[UserController::class,'deshboard'])->name('userdeshboard');


Route::get('/register',[UserController::class,'register'])->name('register');
Route::post('/user/store',[UserController::class,'store'])->name('userstore');


//ADMIN

Route::get('/admin/login',[AdminloginController::class,'index'])->name('adminlogin');
Route::get('/admin/adminloginchk',[UserController::class,'loginchk'])->name('adminckeck');

Route::get('/admin/deshboard',[UserController::class,'deshboard'])->name('admindeshboard');





//User Auth
// Route::middleware(['auth','user-access::1'])->group(function (){
//     Route::get('/user/deshboard', [HomeController::class, 'userdesh'])->name('userhome');
// });

// //Admin Auth
// Route::middleware(['auth','user-access::2'])->group(function (){
//     Route::get('/admin/deshboard', [HomeController::class, 'admindesh'])->name('adminhome');
//});


