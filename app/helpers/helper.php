<?php

use App\Models\user;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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

function cartCount(){
    $userId = Auth::user()->id;
    return $totalItemCount  = DB::table('carts')
        ->where('user_id', $userId)
        ->count();
}


function orderItemCount(){
    $userId = Auth::user()->id;
    return $orderItemCount  = DB::table('order_items')
        ->where('user_id', $userId)
        ->count();
}

function productImage($id){
    return $product = Product::where('id',$id)->select('image')->get();
}




