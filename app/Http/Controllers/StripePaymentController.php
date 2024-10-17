<?php

namespace App\Http\Controllers;

use Stripe\Stripe;

// use Stripe;
// use Session;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class StripePaymentController extends Controller
{


   //* success response method.



   public function stripe(Request $request)

   {
      // dd($request->all());
      // Define validation rules
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

      // Perform validation
      $validator = Validator::make($request->all(), $rules);

      // Return an error if validation fails
      if ($validator->fails()) {
         return redirect()->route('user.checkout')->with('status', 'Please Check Detail Correctly And Fill Up Them.');
      }
      $user = Auth::user();
      $userId = $user->id;
      $totalSum = DB::table('carts')
         ->join('products', 'carts.product_id', '=', 'products.id')
         ->where('carts.user_id', $userId)
         ->select(DB::raw('SUM(carts.qty * products.price) as totalSum'))
         ->pluck('totalSum')
         ->first();


      $discount = session('discount_amount', 0);
      $newTotal = session('new_total', $totalSum);
      $couponCode = session('coupon_code', null);

      // Set your secret key. Remember to switch to your live secret key in production.
      // See your keys here: https://dashboard.stripe.com/apikeys
      $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
      // dd($stripe);


      $totalSum = array_reduce($request->price, function ($carry, $item) use ($request) {
         return $carry + ($item * $request->quantity[array_search($item, $request->price)]);
      }, 0);

      $discount = session('discount_amount', 0);
      $newTotal = $totalSum - $discount; // Calculate the new total

      // Ensure newTotal is not negative
      if ($newTotal < 0) {
         $newTotal = 0;
      }

      $lineItems = [];
      foreach ($request->prod_name as $index => $prodName) {
         $originalPrice = $request->price[$index];
         $quantity = $request->quantity[$index];

         // Calculate discounted price for each item
         $discountedPrice = $originalPrice;

         if ($discount > 0) {
            $itemDiscount = ($originalPrice / $totalSum) * $discount;
            $discountedPrice = $originalPrice - $itemDiscount; // Apply discount to original price
         }

         $discountedPrice = max(0, $discountedPrice);

         $lineItems[] = [
            'price_data' => [
               'currency' => 'inr',
               'product_data' => [
                  'name' => $prodName,
               ],
               'unit_amount' => round($discountedPrice * 100), // Use discounted price
            ],
            'quantity' => $quantity,
         ];
      }

      $response = $stripe->checkout->sessions->create([
         'line_items' => $lineItems,
         'mode' => 'payment',
         'success_url' => route('successs') . '?session_id={CHECKOUT_SESSION_ID}',
         'cancel_url' => route('cancell'),
      ]);

      // dd($response); 


      // dd($lineItems);
      //store Request in session
      session()->put('order_data', [
         'first_name' => $request->first_name,
         'last_name' => $request->last_name,
         'email' => $request->email,
         'country' => $request->country,
         'address' => $request->address,
         'apartment' =>  $request->apartment,
         'city' => $request->city,
         'state' => $request->state,
         'zip' => $request->zip,
         'mobile' => $request->mobile,
         'order_notes' => $request->order_notes,
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
      if (isset($request->session_id)) {
         $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

         $session = $stripe->checkout->sessions->retrieve($request->session_id);

         $paymentTypeId = $session->payment_intent;
         // dd($paymentTypeId);

         if ($session->payment_status === 'paid') {
            $user = Auth::user();
            $userId = $user->id;

            // Get product data 
            $product = DB::table('carts')
               ->join('products', 'carts.product_id', '=', 'products.id')
               ->where('carts.user_id', $userId)
               ->select('products.*', 'carts.qty as cqty')
               ->get();

            // Calculate total sum from the cart
            $totalSum = DB::table('carts')
               ->join('products', 'carts.product_id', '=', 'products.id')
               ->where('carts.user_id', $userId)
               ->select(DB::raw('SUM(carts.qty * products.price) as totalSum'))
               ->pluck('totalSum')
               ->first();

            // Create a new order session
            $orderData = session()->get('order_data');

            // dd($orderData);

            // Store Customer Address

            CustomerAddress::updateOrCreate(
               ['user_id' => $userId],
               [
                  'user_id' => $userId,
                  'first_name' => $orderData['first_name'],
                  'last_name' => $orderData['last_name'],
                  'email' => $orderData['email'],
                  'country' => $orderData['country'],
                  'address' => $orderData['address'],
                  'apartment' => $orderData['apartment'] ?? null,
                  'city' => $orderData['city'],
                  'state' => $orderData['state'],
                  'pincode' => $orderData['zip'],
                  'mobile' => $orderData['mobile'],
                  'notes' => $orderData['order_notes'] ?? null,
               ]
            );

            $couponCode = session('coupon_code', null);
            $discountAmount = session('discount_amount', 0);
            $newTotal = session('new_total', $totalSum);

            // Create a new order
            $order = new Order();
            $order->subtotal = $totalSum;
            $order->shipping = 0;
            $order->grand_total = $newTotal;
            $order->discount = $discountAmount;
            $order->coupon_code = $couponCode;
            $order->payment_status = 'paid with Stripe Card';
            $order->payment_id = $paymentTypeId;
            $order->user_id = $userId;
            $order->first_name = $orderData['first_name'];
            $order->last_name = $orderData['last_name'];
            $order->email = $orderData['email'];
            $order->country = $orderData['country'];
            $order->address = $orderData['address'];
            $order->city = $orderData['city'];
            $order->state = $orderData['state'];
            $order->pincode = $orderData['zip'];
            $order->mobile = $orderData['mobile'];
            $order->notes = $orderData['order_notes'];
            $order->save();


            // Retrieve the order ID for order items
            $orderId = $order->id;

            // Store order items
            foreach ($product as $products) {
               DB::table('order_items')->insert([
                  'order_id' => $orderId,
                  'product_id' => $products->id,
                  'name' => $products->prod_name,
                  'qty' => $products->cqty,
                  'price' => $products->price,
                  'total' => $products->cqty * $products->price,
                  'created_at' => now(),
                  'updated_at' => now(),
               ]);
            }

            sendEmail($orderId);


            // Clear the cart after successful payment
            Cart::where('user_id', $userId)->delete();

            $request->session()->forget('order_data');

            // Redirect with success message
            return redirect()->route('user.view_order')->with('status', 'Payment is successful and your order is placed.');
         } else {
            return redirect()->route('cancell')->with('error', 'Payment was not successful.');
         }
      }

      return redirect()->route('cancell')->with('error', 'Invalid session ID.');
   }


   public function cancel()
   {
      return redirect()->route('user.index')->with('error', 'Payment Is Unsuccessful.');

      // return "Payment Is Unsuccessful";
   }

   

   public function refund(Request $request)
   {
      $order = Order::find($request->order_id); 
      $paymentIntentId = $order->payment_id;

      // Set Stripe secret key
      \Stripe\Stripe::setApiKey(config('stripe.stripe_sk'));
      // $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));


      try {
         $refund = \Stripe\Refund::create([
            'payment_intent' => $paymentIntentId, 
         ]);
         // dd($refund);
         // dd('hello');
         $orderId = $order->id;

         $order->status = 'refunded';
         $order->refund_id = $refund->id;
         // dd($order);
         $order->save();

         //Mail For Refund
         refundOrderAmount($orderId);


         return redirect()->back()->with('status', 'Refund Successful!');
      } catch (\Stripe\Exception\ApiErrorException $e) {
         return redirect()->back()->with('error', 'Refund Failed: ' . $e->getMessage());
      }
   }
}
