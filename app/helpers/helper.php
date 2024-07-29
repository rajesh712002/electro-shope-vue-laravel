<?php

use App\Models\user;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


function getcategory()
{
    return  $category = Category::withCount('product','subcategory')->get();
}



function getproduct(){
    return $product = Product::orderBy('created_at', 'desc')->limit(12)->get();

}



