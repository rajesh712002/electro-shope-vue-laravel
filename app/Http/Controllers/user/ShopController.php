<?php

namespace App\Http\Controllers\user;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ShopController extends Controller
{
    public function shop(Request $request,$categoryslug = null, $subcategoryslug = null )
    {
        $categorys = Category::withCount('product')->get();
        $products = Product::where('status', '1');
        
        //Filter
        if(!empty($categoryslug)){
            $category = Category::where('slug',$categoryslug)->first();
            @dd($category->id);
            $products = $products->where('category_id',$category->id);
        }
        $products = $products->orderBy('created_at', 'desc')->limit(12)->get();
        $brands = Brand::where('status', '1')->get();

        return view('user.order.shop', compact('brands', 'products', 'categorys'));
    }
}
