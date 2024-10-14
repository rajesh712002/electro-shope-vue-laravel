<?php

namespace App\Http\Controllers\user;

use Stripe;
use App\Models\Cart;
use App\Models\Order;
use App\Mail\OrderEmail;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\DiscountCoupon;
use Illuminate\Support\Carbon;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\StripePaymentController;

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
        $couponCode = session('coupon_code', null);
        $discount = session('discount_amount', 0);
        $newTotal = session('new_total', $totalSum);

        $CustomerAddress = CustomerAddress::where('user_id', '=', $userId)->first();

        // dd($CustomerAddress->user_id);
        return view("user.order.checkout", compact('product', 'totalSum', 'user', 'CustomerAddress', 'userId','couponCode','discount','newTotal'));
    }


    public function applyCoupon(Request $request)
    {

        $user = Auth::user();
        $couponCode = $request->input('coupon_code');

        // Timezone and current time
        $timezone = 'Asia/Kolkata';
        $currentTime = Carbon::now($timezone);

        // Fetch the coupon
        $coupon = DiscountCoupon::where('code', $couponCode)
            ->where('status', '1')
            ->where('starts_at', '<=', $currentTime)
            ->where('expires_at', '>=', $currentTime)
            ->first();

            // dd($coupon);
        // Check if coupon exists and is valid
        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid coupon code or coupon has expired.'
            ]);
        }

        // Calculate total cart sum
        $totalSum = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $user->id)
            ->select(DB::raw('SUM(carts.qty * products.price) as totalSum'))
            ->pluck('totalSum')
            ->first();

        // Check if the total amount qualifies for the coupon
        if ($totalSum < $coupon->min_amount) {
            return response()->json([
                'success' => false,
                'message' => "The total amount does not meet the minimum required amount of {$coupon->min_amount} for this coupon."
            ]);
        }

        // Check if the coupon has reached the maximum number of uses
        $totalUses = Order::where('coupon_code', '=', $coupon->code)
            ->distinct('user_id') // only one use per user is counted
            ->count('user_id');

        if ($totalUses >= $coupon->max_uses_user) {
            return response()->json([
                'success' => false,
                'message' => 'This coupon has reached its usage limit for all users.'
            ]);
        }

        // Check specific user usage limit
        $userUses = Order::where('user_id', $user->id)
            ->where('coupon_code', $coupon->code)
            ->count();

        if ($userUses >= $coupon->max_uses) {
            return response()->json([
                'success' => false,
                'message' => 'You have already used this coupon the maximum number of times allowed.'
            ]);
        }

        // Apply the coupon based on its type (fixed or percentage)
        if ($coupon->type == 'fixed') {
            $discount = $coupon->discount_amount;
        } else {
            $discount = ($totalSum * $coupon->discount_amount) / 100;
        }

        // Calculate the new total
        $newTotal = $totalSum - $discount;
        session([
            'coupon_code' => $coupon->code,
            'discount_amount' => $discount,
            'new_total' => $newTotal,
        ]);
        // dd($discount, $newTotal, $couponCode);

        // Return success response with discount and new total
        return response()->json([
            'success' => true,
            'discountAmount' => $discount,
            'newTotal' => $newTotal,
            'couponCode' => $couponCode
        ]);
    }

    public function storeCheckout(Request $request)
    {
        $userId = Auth::user()->id;

        //Fatch Products From Cart
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
            'first_name' => 'required|string|max:50',
            'last_name' => 'required|string|max:50',
            'email' => 'required|email|max:50',
            'country' => 'required',
            'address' => 'required|max:50',
            'city' => 'required|string|max:50',
            'state' => 'required|string|max:50',
            'zip' => 'required|digits_between:3,10',
            'mobile' => 'required|digits:10',


        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Store in session

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

        // Apply the coupon
        $couponCode = session('coupon_code', null);
        $discountAmount = session('discount_amount', 0);
        $newTotal = session('new_total', $totalSum);

        // Default values in case no coupon is applied
        $discount = 0;
        $newTotal = 0;

        
        
        // dd($discount, $newTotal, $couponCode);
        if ($request->payment_method == 'cod') {
            $shipping = 0;
            $discountCode = '';
            $discount = 0;
            $subtotal = $totalSum;
            
            $couponCode = session('coupon_code', null);
            $discount = session('discount_amount', 0);
            $newTotal = session('new_total', $totalSum);
            $order = new Order();
            // $order->subtotal = $totalSum;
            // $order->shipping = $shipping;
            // $order->grand_total = $totalSum;
            // $order->subtotal = $totalSum;

            $order->subtotal = $totalSum;
            $order->shipping = $shipping;
            $order->grand_total = $newTotal;
            $order->discount = $discount;
            $order->coupon_code = $couponCode;

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

        // if ($request->payment_method == 'stripecard') {

        //     $stripe = new StripePaymentController();

        //     $result = $stripe->stripe($request);

        //     // dd($result);

        //     // $shipping = 0;
        //     // $discount = 0;
        //     // $subtotal = $totalSum;

        //     // $order = new Order();
        //     // $order->subtotal = $totalSum;
        //     // $order->shipping = $shipping;
        //     // $order->grand_total = $totalSum;
        //     // $order->subtotal = $totalSum;

        //     // $order->payment_status = 'paid with Stripe Card';
        //     // $order->user_id = $user->id;
        //     // $order->first_name = $request->first_name;
        //     // $order->last_name = $request->last_name;
        //     // $order->email = $request->email;
        //     // $order->country = $request->country;
        //     // $order->address = $request->address;
        //     // $order->apartment =  $request->appartment;
        //     // $order->city = $request->city;
        //     // $order->state = $request->state;
        //     // $order->pincode =  $request->zip;
        //     // $order->mobile = $request->mobile;
        //     // $order->notes = $request->order_notes;
        //     // $order->save();
        // }




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

        session()->forget(['coupon_code', 'discount_amount', 'new_total']);
        //=======//============//==============//======================//==============================//
        //Make Cart Empty 

        $user_id = Auth::user()->id;
        $user_cart_id = Cart::where('user_id', '=', $user_id)->select('user_id as cUid');
        if ($user_cart_id) {
            $cart = Cart::where('user_id', Auth::user()->id);
            $cart->delete();
        }
    }


    //=======//==============//=====================//============================//===================================//

    public function orderEmail($orderId)
    {
        $order = Order::where('id', $orderId)->first();
        $mailData = [
            'subject' => 'Thamks for your order',
            'order' => $order
        ];

        // dd($order);
        Mail::to($order->email)->send(new OrderEmail($mailData));
    }
}
