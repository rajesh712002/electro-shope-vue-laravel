<?php

namespace App\Http\Controllers\user;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;

class ShopController extends Controller
{
    public function shop($categoryslug = null, $subcategoryslug = null)
    {
        // dd("here");
        // dd($categoryslug);
        // dd("here");
        $categorySelected='';
        $subcategorySelected='';
        $brandsArray = [];

        // if(!empty($request->get('brand')))
        // {
        //     $brandsArray = explode(',',$request->get('brand'));
        //     dd($brandsArray);
        // }

        $categorys = Category::withCount('product')->get();
        $products = Product::where('status', 1);
        //Filter
        if(!empty($categoryslug)){
            $category = Category::where('slug',$categoryslug)->first();
            //@dd($category->id);
            $products = $products->where('category_id',$category->id);
            $categorySelected = $category->id;
        }
        if(!empty($subcategoryslug)){
            $subcategory = Subcategory::where('slug',$subcategoryslug)->first();
            //@dd($subcategory->id);
            $products = $products->where('sub_category_id',$subcategory->id);
            $subcategorySelected = $subcategory->id;
        }
        $products = $products->orderBy('created_at', 'desc');
        $products = $products->paginate(9);
        $brands = Brand::where('status', '1')->get();

        return view('user.order.shop', compact('brands', 'products', 'categorys','categorySelected','subcategorySelected','brandsArray'));
    }



    public function view_product($slug){
        // dd($slug);
        $product = Product::with('brand')->where('slug',$slug)->first();
        // dd($product);
        return view("user.order.product",compact('product'));
    }


    public function addToCart(){

    }

    public function removeToCard(){

    }
    
    public function view_cart($slug=null)
    {
        $product = Product::where('slug',$slug)->first();
        return view('user.order.cart',compact('product'));
    }
}
