<?php

namespace App\Http\Controllers\user;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {


        Cart::instance('cart')->add($request->id, $request->prod_name, 1, $request->price)->associate('App\Model\Product');
        return redirect()->back();
    }


    // public function view_cart($slug = null)
    // {
    //     // dd(Cart::content());
    //     $product = Product::where('slug', $slug)->first();
    //     return view('user.order.cart', compact('product'));
    // }

    public function index()
    {
        $items = Cart::instance('cart')->content();
        return view('user.order.cart', compact('items'));
    }

    public function increaseCartQty($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty + 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function decreaseCartQty($rowId)
    {
        $product = Cart::instance('cart')->get($rowId);
        $qty = $product->qty - 1;
        Cart::instance('cart')->update($rowId, $qty);
        return redirect()->back();
    }

    public function remove_item($rowId)
    {
        Cart::instance('cart')->remove($rowId);
        return redirect()->back();
    }



    //Wishlist


    public function wishlist()
    {
        $items = Cart::instance('wishlist')->content();
        return view('user.order.wishlist', compact('items'));
        //  return view('user.order.wishlist');
    }

    public function addToWishlist(Request $request)
    {
        Cart::instance('wishlist')->add($request->id, $request->prod_name, 1, $request->price)->associate('App\Model\Product');
        return redirect()->back();
    }
}
