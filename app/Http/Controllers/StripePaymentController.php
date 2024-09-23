<?php

namespace App\Http\Controllers;

use Stripe;
// use Session;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StripePaymentController extends Controller
{


   //* success response method.



   public function stripe(Request $request)

   {
      // dd($request->all());
      // Set your secret key. Remember to switch to your live secret key in production.
      // See your keys here: https://dashboard.stripe.com/apikeys
      $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
      // dd($stripe);

      $lineItems = [];

      foreach ($request->prod_name as $index => $prodName) {
         $lineItems[] = [
            'price_data' => [
               'currency' => 'usd',
               'product_data' => [
                  'name' => $prodName
               ],
               'unit_amount' => $request->price[$index] * 100,
            ],
            'quantity' => $request->quantity[$index],
         ];
      }


      $response = $stripe->checkout->sessions->create([
         'line_items' => $lineItems,
         'mode' => 'payment',
         'success_url' => route('successs') . '?session_id={CHECKOUT_SESSION_ID}',
         'cancel_url' => route('cancell'),
      ]);

      // dd($response);

      // dd($response);
      if (isset($response->id) && $response->id != '') {
         session()->put('prod_name', $request->prod_name);
         session()->put('quantity', $request->quantity);
         session()->put('price', $request->price);




         return redirect($response->url);
      } else {
         return redirect()->route('cancell');
      }
   }





   // * success response method.





   public function success(Request $request)
   {
      // if (isset($request->session_id)) {

      //    $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
      //    // dd($stripe);
      //    $response = $stripe->checkout->sessions->retrieve($request->session_id);
      //    dd($response);
      $orderData = $request->session()->get('order_data');

      // dd( $orderData);
      $userId = Auth::user()->id;
      $user = Auth::user();

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

      $shipping = 0;
      $discount = 0;
      $subtotal = $totalSum;

      $order = new Order();
      $order->subtotal = $totalSum;
      $order->shipping = $shipping;
      $order->grand_total = $totalSum;
      $order->subtotal = $totalSum;

      $order->payment_status = 'paid with Stripe Card';
      $order->user_id = $user->id;
      $order->first_name = $orderData['first_name'];
      $order->last_name = $orderData['last_name'];
      $order->email = $orderData['email'];
      $order->country = $orderData['country'];
      $order->address = $orderData['address'];
      $order->apartment = $orderData['apartment'];
      $order->city = $orderData['city'];
      $order->state = $orderData['state'];
      $order->pincode = $orderData['pincode'];
      $order->mobile = $orderData['mobile'];
      $order->notes = $orderData['notes'];
      $order->save();


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

      // Optionally clear session data if no longer needed
      $request->session()->forget('order_data');


      return redirect()->route('user.index')->with('status', 'Payment Is Successful and Your Order Is Placed');

      // return "Payment Is Successful";
      // }
   }

   public function cancel()
   {
      return redirect()->route('user.index')->with('status', 'Payment Is Unsuccessful.');

      // return "Payment Is Unsuccessful";
   }
}
