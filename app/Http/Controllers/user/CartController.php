<?php

namespace App\Http\Controllers\user;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Wishlist;

// use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $userId = Auth::user()->id;
        $cart_prod_id =  DB::table('carts')
            ->where('product_id', '=', $request->prod_id)
            ->where('user_id', '=', $userId)
            ->exists();

        if ($cart_prod_id) {
        } else {
            $cart = new  Cart();
            $cart->product_id = $request->prod_id;
            $cart->user_id = $request->user_id;
            $cart->qty = $request->qty;
            $cart->save();
        }

        return redirect()->back();
    }


    public function index()
    {
        $userId = Auth::user()->id;

        // dd($cart_prod_id);

        $product = DB::table('carts')
            ->join('users', 'carts.user_id', '=', 'users.id')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('users.id', $userId)
            ->select('products.*', 'carts.qty as cqty', 'carts.id as cid')
            ->get();

        $totalSum = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $userId)
            ->select(DB::raw('SUM(carts.qty * products.price) as totalSum'))
            ->pluck('totalSum')
            ->first();
        // dd($product);
        return view('user.order.cart', compact('product', 'totalSum'));
    }

    public function increaseCartQty(Request $request, $id)
    {

        $cart = Cart::findOrFail($id);

        $userId = Auth::user()->id;
        $cart_prod_id =  DB::table('carts')
            ->where('product_id', '=', $request->prod_id)
            ->where('user_id', '=', $userId)
            ->exists();

        $product = DB::table('carts')
            ->join('users', 'carts.user_id', '=', 'users.id')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('users.id', $userId)
            ->select('products.qty as pqty', 'carts.qty as cqty')
            ->first();

        if ($cart_prod_id) {
        } else {
            // dd($product->pqty);
            // if ($product) {
            
            if ($product->cqty != $product->pqty) {
                $cart->qty +=  1;
                $cart->save();
            }
            // }
        }
        return redirect()->back();
    }

    public function decreaseCartQty(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $userId = Auth::user()->id;
        $cart_prod_id =  DB::table('carts')
            ->where('product_id', '=', $request->prod_id)
            ->where('user_id', '=', $userId)
            ->exists();

        if ($cart_prod_id) {
        } else {
            if ($cart->qty > 1) {
                $cart->qty += $request->qty - 1;
                $cart->save();
            }
        }
        return redirect()->back();
    }

    public function remove_item($id)
    {
        $product = Cart::findOrFail($id);
        $product->delete();
        return redirect()->back();
    }



    //========//
    //Wishlist//


    public function wishlist()
    {
        $userId = Auth::user()->id;

        // dd($cart_prod_id);

        $product = DB::table('wishlists')
            ->join('users', 'wishlists.user_id', '=', 'users.id')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->where('users.id', $userId)
            ->select('products.*', 'wishlists.id as wid')
            ->get();
        // dd($product);
        return view('user.order.wishlist', compact('product'));
    }

    public function addToWishlist(Request $request)
    {
        $userId = Auth::user()->id;
        $cart_prod_id =  DB::table('wishlists')
            ->where('product_id', '=', $request->prod_id)
            ->where('user_id', '=', $userId)
            ->exists();

        if ($cart_prod_id) {
        } else {
            $cart = new  Wishlist();
            $cart->product_id = $request->prod_id;
            $cart->user_id = $request->user_id;
            $cart->save();
        }
        return redirect()->back();
    }

    public function remove_wishlist($id)
    {
        $product = Wishlist::findOrFail($id);
        $product->delete();
        return redirect()->back();
    }

    public function moveToCart(Request $request, $id)
    {
        $userId = Auth::user()->id;
        $cart_prod_id =  DB::table('carts')
            ->where('product_id', '=', $request->prod_id)
            ->where('user_id', '=', $userId)
            ->exists();

        if ($cart_prod_id) {
            $product = Wishlist::findOrFail($id);
            $product->delete();
        } else {

            $cart = new  Cart();
            $cart->product_id = $request->prod_id;
            $cart->user_id = $request->user_id;
            $cart->qty = $request->qty;
            $cart->save();

            $product = Wishlist::findOrFail($id);
            $product->delete();
        }

        return redirect()->back();
    }

    public function checkout()
    {
        return view('user.order.checkout');
    }
}
