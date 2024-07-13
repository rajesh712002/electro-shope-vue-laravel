<?php

use App\Http\Controllers\user\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


//USER

Route::get('/register',[UserController::class,'register'])->name('register');
Route::get('/user/login',[UserController::class,'login'])->name('login');


//ADMIN
