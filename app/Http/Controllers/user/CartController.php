<?php

namespace App\Http\Controllers\user;

use App\Models\Cart;
use App\Models\Product;
// use Auth;
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

        // Cart::instance('cart')->add($request->id, $request->prod_name, 1, $request->price)->associate('App\Model\Product');
        if ($cart_prod_id) {
        } else {
            $cart = new  Cart();
            $cart->product_id = $request->prod_id;
            $cart->user_id = $request->user_id;
            $cart->qty = $request->qty;
            $cart->save();
        }
        //       $product->slug = $request->slug;

        return redirect()->back();
    }


    public function index()
    {
        //$items = Cart::instance('cart')->content();
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
        return view('user.order.cart', compact('product','totalSum'));
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
            ->select('products.qty as pqty')
            ->first($id);

        if ($cart_prod_id) {
        } else {
            // dd($product->pqty );
            if ($cart->qty != $product->pqty) {
                $cart->qty +=  1;
                $cart->save();
            }
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



    //Wishlist


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

        //  return view('user.order.wishlist');
    }

    public function addToWishlist(Request $request)
    {
        // Cart::instance('wishlist')->add($request->id, $request->prod_name, 1, $request->price)->associate('App\Model\Product'); //, ['productImage' => $product->image]
        $userId = Auth::user()->id;
        $cart_prod_id =  DB::table('wishlists')
            ->where('product_id', '=', $request->prod_id)
            ->where('user_id', '=', $userId)
            ->exists();

        // Cart::instance('cart')->add($request->id, $request->prod_name, 1, $request->price)->associate('App\Model\Product');
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

    public function moveToCart(Request $request,$id)
    {
        // $item = Cart::instance('wishlist')->get($rowId);
        // Cart::instance('cart')->add($item->id, $item->name, $item->qty, $item->price)->associate('App\Model\Product');
        // Cart::instance('wishlist')->remove($rowId);
        //    dd($item->id);

        $userId = Auth::user()->id;
        $cart_prod_id =  DB::table('carts')
            ->where('product_id', '=', $request->prod_id)
            ->where('user_id', '=', $userId)
            ->exists();

        // Cart::instance('cart')->add($request->id, $request->prod_name, 1, $request->price)->associate('App\Model\Product');
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
