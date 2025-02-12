<?php

use App\Http\Controllers\admin\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// //Update Sub
// //Delete SubCategory