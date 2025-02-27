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
use App\Models\ProductImage;
use App\Models\ProductRating;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    // public function shop($categoryslug = null, $subcategoryslug = null)
    // {

    //     $categorySelected = '';
    //     $subcategorySelected = '';
    //     $brandsArray = [];

    //     $categorys = Category::withCount('product')->get();
    //     $products = Product::with('productImages')->where('status', 1);

    //     // $images = DB::table('product_images')
    //     //         ->join('products','products.id' ,'=' ,'product_images.product_id')
    //     //         ->where('products.id','=',$products->id)->first();
    //     // dd( $products);
    //     //Filter
    //     if (!empty($categoryslug)) {
    //         $category = Category::where('slug', $categoryslug)->first();
    //         //@dd($category->id);
    //         $products = $products->where('category_id', $category->id);
    //         $categorySelected = $category->id;
    //     }
    //     if (!empty($subcategoryslug)) {
    //         $subcategory = Subcategory::where('slug', $subcategoryslug)->first();
    //         //@dd($subcategory->id);
    //         $products = $products->where('sub_category_id', $subcategory->id);
    //         $subcategorySelected = $subcategory->id;
    //     }

    //     $keyword = request()->query('keyword');
    //     if (!empty($keyword)) {
    //         $products = $products->where('prod_name', 'like', '%' . $keyword . '%'); // Search by product name
    //     }

    //     $sort = request()->query('sort');
    //     if ($sort == 'price_desc') {
    //         $products = $products->orderBy('price', 'desc');
    //     } elseif ($sort == 'price_asc') {
    //         $products = $products->orderBy('price', 'asc');
    //     } else {
    //         // Default sorting, for example by latest
    //         $products = $products->orderBy('created_at', 'desc');
    //     }
    //     // $products = $products->orderBy('created_at', 'desc');
    //     $products = $products->paginate(3);
    //     // dd( $products);
    //     $brands = Brand::where('status', '1')->get();
    //     return response()->json(['brands' => $brands, 'products'=>$products, 'categorys'=>$categorys, 'subcategorySelected'=>$subcategorySelected, 'brandsArray'=>$brandsArray]);
    //     // return view('user.order.shop', compact('brands', 'products', 'categorys', 'categorySelected', 'subcategorySelected', 'brandsArray'));
    // }


    public function shop(Request $request)
    {
        $categorySelected = null;
        $subcategorySelected = null;
        $brandsArray = [];
    
        $categorys = Category::withCount('product')->get();
        $products = Product::with('productImages')->where('status', 1);
    
        // Fetch Filters from Request
        $categoryslug = $request->query('categoryslug');
        $subcategoryslug = $request->query('subcategoryslug');
        $keyword = $request->query('keyword');
        $sort = $request->query('sort');
    
        // Category Filter
        if (!empty($categoryslug)) {
            $category = Category::where('slug', $categoryslug)->first();
            if ($category) {
                $products = $products->where('category_id', $category->id);
                $categorySelected = $category->id;
            } else {
                return response()->json(['error' => 'Category not found'], 404);
            }
        }
    
        // Subcategory Filter
        if (!empty($subcategoryslug)) {
            $subcategory = Subcategory::where('slug', $subcategoryslug)->first();
            if ($subcategory) {
                $products = $products->where('sub_category_id', $subcategory->id);
                $subcategorySelected = $subcategory->id;
            } else {
                return response()->json(['error' => 'Subcategory not found'], 404);
            }
        }
    
        // Search Filter
        if (!empty($keyword)) {
            $products = $products->where('prod_name', 'like', '%' . $keyword . '%');
        }
    
        // Sorting
        if ($sort == 'price_desc') {
            $products = $products->orderBy('price', 'desc');
        } elseif ($sort == 'price_asc') {
            $products = $products->orderBy('price', 'asc');
        } else {
            $products = $products->orderBy('created_at', 'desc');
        }
    
        // Paginate Results
        $products = $products->paginate(3);
    
        $brands = Brand::where('status', '1')->get();
        return response()->json([
            'brands' => $brands,
            'products' => $products,
            'categorys' => $categorys,
            'categorySelected' => $categorySelected,
            'subcategorySelected' => $subcategorySelected,
            'brandsArray' => $brandsArray
        ]);
    }
    


    public function view_product(Request $request, $slug)
    {
        // if (Auth::check()) {
            $user_id = 7;//Auth::user()->id;

            // Get order details 
            $order = DB::table('order_items')
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where('orders.user_id', '=', $user_id)
                ->select('orders.user_id as orUid', 'order_items.product_id as prod_id')
                ->first();
        // } else {

        //     $order = null;
        // }

        // get product details 
        $product = Product::with('brand')->where('slug', $slug)->first();
        $images = DB::table('product_images')
            ->join('products', 'products.id', '=', 'product_images.product_id')
            ->where('products.id', '=', $product->id)->get();
        $productrat = ProductRating::get();
        // dd($images);
        // Calculate the count of ratings for the product
        $ratingcount = DB::table('product_ratings')
            ->join('products', 'products.id', '=', 'product_ratings.product_id')
            ->where('products.slug', '=', $slug)
            ->count();

        // Calculate the sum of ratings for the product
        $ratingsum = DB::table('product_ratings')
            ->join('products', 'products.id', '=', 'product_ratings.product_id')
            ->where('products.slug', '=', $slug)
            ->sum('product_ratings.rating');

            return response()->json(['product'=>$product, 'order'=>$order, 'productrat'=>$productrat, 'ratingcount'=>$ratingcount, 'ratingsum'=>$ratingsum, 'images'=>$images]);
        // return view("user.order.product", compact('product', 'order', 'productrat', 'ratingcount', 'ratingsum', 'images'));
    }


    //========//==============//===================//
    //Review Rating 

    public function saveRating(Request $request, $id)
    {
        $validate = [
            'name' => 'required|string',
            'email' => 'required|email|max:100',
            'comment' => 'required',
            'rating' => 'required'

        ];
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user_email = Auth::user()->email;


        $productsum = Product::where('slug');

        $product = Product::find($id);
        if (!$product) {
            return response()->json(['errors' => 'Product not found'], 404);
        }

        $userchk = DB::table('product_ratings')
            ->where('email', $request->email)
            ->where('product_id', $id)
            ->exists();
        // dd($userchk);
        if ($userchk) {
            $ratings = ProductRating::updateOrCreate(
                attributes: [
                    'product_id' => $id,
                    'email' => $request->email,
                ],
                values: [
                    'username' => $request->name,
                    'comment' => $request->comment,
                    'rating' => $request->rating
                ]
            );
            return response()->json(['redirect_url' => route('viewproduct', ['slug' => $product->slug])]);
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

            return response()->json(['redirect_url' => route('viewproduct', ['slug' => $product->slug])]);
        }
    }
}
