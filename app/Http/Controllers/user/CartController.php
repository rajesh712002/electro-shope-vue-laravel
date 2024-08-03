<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        

        
        // $product = Product::find($request->id);
        // if ($product == null) {
        //     return response()->json([
        //         'status' => false,
        //         'message' => 'Product Not Found'
        //     ]);
        // }
        // if (Cart::count() > 0) {
        //     echo "Product Exist";
        // } else {
        //     echo "Cart is empty";
        //     Cart::add($product->id, $product->prod_name, 1, $product->price);//, ['productImage' => $product->image]
        //     $status = true;
        //     $message = 'Product Added';
            
        // }
        // // dd($message );
        // return response()->json([
        //     'status' => $status,
        //     'message' => $message
        // ]);
    }

    public function updateToCart()
    {
    }

    public function removeToCard()
    {
    }

    public function view_cart($slug = null)
    {
        // dd(Cart::content());
        $product = Product::where('slug', $slug)->first();
        return view('user.order.cart', compact('product'));
    }
}
