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
        if (Auth::check()) {

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
            session()->forget(['coupon_code', 'discount_amount', 'new_total']);
            return redirect()->route('user.index')->with('status', 'Product added to cart successfully.');
        } else {
            // session()->forget('cart');

            // Guest User Save to Session
            $cart = session()->get('cart', []);

            // Check if product is already in cart
            if (isset($cart[$request->prod_id])) {
                $cart[$request->prod_id]['qty'] += $request->qty;
            } else {
                // Add new product to cart
                $cart[$request->prod_id] = [
                    'product_id' => $request->prod_id,
                    'qty' => $request->qty,
                    'price' => $request->price,
                    'name' => $request->name,
                    'image' => $request->image,
                    'max_qty' => $request->max_qty

                ];
            }

            session()->put('cart', $cart);
            // dd(vars: $cart);
            return redirect()->route('user.index')->with('status', 'Product added to cart successfully.');
        }
    }


    public function index()
    {

        if (Auth::check()) {

            $userId = Auth::user()->id;

            // dd($cart_prod_id);

            //show item in cart
            $product = DB::table('carts')
                ->join('users', 'carts.user_id', '=', 'users.id')
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->leftJoin('product_images', function ($join) {
                    $join->on('product_images.product_id', '=', 'products.id')
                         ->whereRaw('product_images.id = (SELECT MIN(id) FROM product_images WHERE product_images.product_id = products.id)');
                })
                ->where('users.id', $userId)
                ->select('products.*', 'carts.qty as cqty', 'carts.id as cid','product_images.images as images')
                ->get();

                // dd($product);
            //in cart raw
            $totalSum = DB::table('carts')
                ->join('products', 'carts.product_id', '=', 'products.id')
                ->where('carts.user_id', $userId)
                ->select(DB::raw('SUM(carts.qty * products.price) as totalSum'))
                ->pluck('totalSum')
                ->first();
            // dd($product);
            $couponCode = session('coupon_code', null);
            $discount = session('discount_amount', 0);
            $newTotal = session('new_total', $totalSum);
            return view('user.order.cart', compact('product', 'totalSum','couponCode','discount','newTotal'));
        } else {
            // Guest User  Show items from session
            $cart = session()->get('cart', []);
            $product = [];

            // Calculate total sum for guest user
            $totalSum = 0;
            foreach ($cart as $item) {
                $totalSum += $item['qty'] * $item['price'];
                $product[] = (object)[
                    'id' => $item['product_id'],
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'qty' => $item['qty'],
                    'image' => $item['image'],
                    'max_qty' => $item['max_qty']
                ];
            }

            return view('user.order.cart', compact('product', 'totalSum'));
        }
    }

    public function increaseCartQty(Request $request, $id)
    {
        $userId = Auth::user()->id;

        $cart = Cart::where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();
        
        $product = DB::table('products')
            ->where('id', $cart->product_id)
            ->select('qty as pqty')
            ->first();

        if ($product && $cart->qty < $product->pqty) {
            $cart->qty += 1;
            $cart->save();
            session()->forget(['coupon_code', 'discount_amount', 'new_total']);
        }

        // Return updated cart information
        return response()->json([
            'success' => true,
            'newQty' => $cart->qty,
            'newTotal' => $cart->qty * $cart->product->price,
            'coupon_code' => '',
            'discount_amount' => 0,
        ]);
    }

    public function decreaseCartQty(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        if ($cart->qty > 1) {
            $cart->qty -= 1;
            $cart->save();
            session()->forget(['coupon_code', 'discount_amount', 'new_total']);
        }

        return response()->json([
            'success' => true,
            'newQty' => $cart->qty,
            'newTotal' => $cart->qty * $cart->product->price,
            'coupon_code' => '',
            'discount_amount' => 0,
        ]);
    }

    public function remove_item($id)
    {
        $product = Cart::findOrFail($id);
        $product->delete();
        session()->forget(['coupon_code', 'discount_amount', 'new_total']);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart',
            'coupon_code' => '',
            'discount_amount' => 0,
        ]);
    }

    //=======//==============//
    //For Guest Cart
    public function decreaseQtyGuest(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->key])) {
            if ($cart[$request->key]['qty'] > 1) {
                $cart[$request->key]['qty']--;
            }
        }
        session()->put('cart', $cart);
        return response()->json(['status' => 'Quantity decreased']);
    }

    public function increaseQtyGuest(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->key])) {
            if ($cart[$request->key]['qty'] < $cart[$request->key]['max_qty']) {
                $cart[$request->key]['qty']++;
            }
        }
        session()->put('cart', $cart);
        return response()->json(['status' => 'Quantity increased']);
    }

    public function removeItemGuest(Request $request)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$request->key])) {
            unset($cart[$request->key]);
        }
        session()->put('cart', $cart);
        return response()->json(['status' => 'Item removed']);
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
            ->leftJoin('product_images', function ($join) {
                $join->on('product_images.product_id', '=', 'products.id')
                     ->whereRaw('product_images.id = (SELECT MIN(id) FROM product_images WHERE product_images.product_id = products.id)');
            })
            ->where('users.id', $userId)
            ->select('products.*', 'wishlists.id as wid','product_images.images as images')
            ->get();
        // dd($product);
        return view('user.order.wishlist', compact('product'));
    }

    public function addToWishlist(Request $request)
    {
        if (Auth::check()) {
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
            return redirect()->route('usershop')->with('status', 'Product added to Wishlist successfully.');
        } else {
        }
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
        return redirect()->route('user.index')->with('status', 'Product added to cart successfully.');
    }

    public function checkout()
    {
        return view('user.order.checkout');
    }
}
