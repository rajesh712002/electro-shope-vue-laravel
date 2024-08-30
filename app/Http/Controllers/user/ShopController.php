<?php

namespace App\Http\Controllers\user;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function shop($categoryslug = null, $subcategoryslug = null)
    {

        $categorySelected = '';
        $subcategorySelected = '';
        $brandsArray = [];

        $categorys = Category::withCount('product')->get();
        $products = Product::where('status', 1);
        //Filter
        if (!empty($categoryslug)) {
            $category = Category::where('slug', $categoryslug)->first();
            //@dd($category->id);
            $products = $products->where('category_id', $category->id);
            $categorySelected = $category->id;
        }
        if (!empty($subcategoryslug)) {
            $subcategory = Subcategory::where('slug', $subcategoryslug)->first();
            //@dd($subcategory->id);
            $products = $products->where('sub_category_id', $subcategory->id);
            $subcategorySelected = $subcategory->id;
        }
        $products = $products->orderBy('created_at', 'desc');
        $products = $products->paginate(9);
        $brands = Brand::where('status', '1')->get();

        return view('user.order.shop', compact('brands', 'products', 'categorys', 'categorySelected', 'subcategorySelected', 'brandsArray'));
    }



    public function view_product(Request $request, $slug)
    {
        // dd($slug);
        $user_id = Auth::user()->id;

        $product = Product::with('brand')->where('slug', $slug)->first();

        $productrat = ProductRating::get();
            // dd($productrat);
        $order = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.user_id', '=', $user_id)
            ->select('orders.user_id as orUid', 'order_items.product_id as prod_id')
            ->first();

            $ratingcount =DB::table('product_ratings')
            ->join('products','products.id','=','product_ratings.product_id')
            ->where('products.slug','=',$slug)
            // ->select('order_items.rating')
            ->count();

            $ratingsum =DB::table('product_ratings')
            ->join('products','products.id','=','product_ratings.product_id')
            ->where('products.slug','=',$slug)
            ->sum('product_ratings.rating');

            // $ratingsum = OrderItem::get();
        // dd($ratingcount);
        return view("user.order.product", compact('product', 'order','productrat','ratingcount','ratingsum'));
    }


    //========//==============//===================//
    //Review Rating 

    public function saveRating(Request $request, $id)
    {
        $validate = [
            'name' => 'required',
            'email' => 'required|max:100',
            'comment' => 'required',
            'rating' => 'required'

        ];
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_email = Auth::user()->email;


        $productsum = Product::where('slug');


        $userchk = DB::table('product_ratings')
            ->where('email', $request->email)
            ->where('product_id', $id)
            ->exists();
            // dd($userchk);
        if ($userchk) {

            return redirect()->back();
        } else {
            $rating = new ProductRating();
            // $user_id = Auth::user()->id;
            $rating->product_id = $id;
            // $rating->user_id = $user_id;
            $rating->username = $request->name;
            $rating->email = $request->email;
            $rating->comment = $request->comment;
            $rating->rating = $request->rating;
            $rating->save();
            return redirect()->back();
        }
    }
}
