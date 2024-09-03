<?php

namespace App\Http\Controllers\user;

use App\Models\Cart;
use App\Models\Order;
use App\Mail\OrderEmail;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $userId = Auth::user()->id;

        // dd($cart_prod_id);
        $user = CustomerAddress::where('user_id', $userId)->first();

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
        // dd($user);

        $CustomerAddress = CustomerAddress::where('user_id', '=', $userId)->first();

        // dd($CustomerAddress->user_id);
        return view("user.order.checkout", compact('product', 'totalSum', 'user', 'CustomerAddress'));
    }



    public function storeCheckout(Request $request)
    {
        $userId = Auth::user()->id;

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




        $rules = [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|max:50',
            'country' => 'required',
            'address' => 'required|max:50',
            'city' => 'required|max:50',
            'state' => 'required|max:50',
            'zip' => 'required|max:10',
            'mobile' => 'required|max:10|min:10',
            // 'card_number' => 'required|max:10',
            // 'expiry_date' => 'required|max:10',
            // 'cvv' => 'required|max:10',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = Auth::user();


        //=======//============//==============//======================//==============================//

        //        Store Customer Address

        CustomerAddress::updateOrCreate(
            ['user_id' => $user->id],
            [
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'country' => $request->country,
                'address' => $request->address,
                'apartment' => $request->appartment,
                'city' => $request->city,
                'state' => $request->state,
                'pincode' => $request->zip,
                'mobile' => $request->mobile,
                'notes' => $request->order_notes,

            ]

        );


        //=======//============//==============//======================//==============================//

        // Store Data In  Orders

        if ($request->payment_method == 'cod') {
            $shipping = 0;
            $discount = 0;
            $subtotal = $totalSum;

            $order = new Order();
            $order->subtotal = $totalSum;
            $order->shipping = $shipping;
            $order->grand_total = $totalSum;
            $order->subtotal = $totalSum;

            $order->payment_status = 'paid on cod';
            // $order->status = $request->status;
            $order->user_id = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->country = $request->country;
            $order->address = $request->address;
            $order->apartment =  $request->appartment;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->pincode =  $request->zip;
            $order->mobile = $request->mobile;
            $order->notes = $request->order_notes;
            $order->save();
        }

        if ($request->payment_method == 'card') {
            $shipping = 0;
            $discount = 0;
            $subtotal = $totalSum;

            $order = new Order();
            $order->subtotal = $totalSum;
            $order->shipping = $shipping;
            $order->grand_total = $totalSum;
            $order->subtotal = $totalSum;

            $order->payment_status = 'paid with card';
            $order->user_id = $user->id;
            $order->first_name = $request->first_name;
            $order->last_name = $request->last_name;
            $order->email = $request->email;
            $order->country = $request->country;
            $order->address = $request->address;
            $order->apartment =  $request->appartment;
            $order->city = $request->city;
            $order->state = $request->state;
            $order->pincode =  $request->zip;
            $order->mobile = $request->mobile;
            $order->notes = $request->order_notes;
            $order->save();
        }



        //=======//============//==============//======================//==============================//

        // Store Data In Order Items

        $order = DB::table('orders')
            ->select('orders.id')
            ->orderBy('id', 'desc')
            ->first();

        $order_id = $order->id;

        $orderItemsData = [];

        foreach ($product as $products) {
            $orderItemsData[] = [
                'order_id' => $order_id,
                'product_id' => $products->id,
                'name' => $products->prod_name,
                'qty' => $products->cqty,
                'price' => $products->price,
                'total' => $products->cqty * $products->price,
                'created_at' => now(),
                'updated_at' => now(),

            ];
        }

        OrderItem::insert($orderItemsData);

        //Send Email Invoice

        sendEmail($order_id);


        //=======//============//==============//======================//==============================//
        //Make Cart Empty 

        $user_id = Auth::user()->id;
        $user_cart_id = Cart::where('user_id', '=', $user_id)->select('user_id as cUid');
        if ($user_cart_id) {
            $cart = Cart::where('user_id', Auth::user()->id);
            $cart->delete();
        }
    }


    //=======//============//==============//======================//==============================//

    public function orderEmail($orderId)
    {
        $order = Order::where('id', $orderId)->first();
        $mailData = [
            'subject' => 'Thamks for your order',
            'order' => $order
        ];

        dd($order);
        Mail::to($order->email)->send(new OrderEmail($mailData));
    }
}
