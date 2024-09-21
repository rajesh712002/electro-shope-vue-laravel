<?php

namespace App\Http\Controllers;

use Stripe;
// use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StripePaymentController extends Controller
{


   //* success response method.



   public function stripe(Request $request)

   {
      // Set your secret key. Remember to switch to your live secret key in production.
      // See your keys here: https://dashboard.stripe.com/apikeys
      $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
      // dd($stripe);
      $response = $stripe->checkout->sessions->create([
         'line_items' => [
            [
               'price_data' => [
                  'currency' => 'usd',
                  'product_data' => [
                     'name' => $request->prod_name
                  ],
                  'unit_amount' => $request->price * 100,
                  // 'tax_behavior' => 'exclusive',
               ],
               'quantity' => $request->quantity,
            ],
         ],
         'mode' => 'payment',
         'success_url' => route('successs') . '?session_id={CHECKOUT_SESSION_ID}',
         'cancel_url' => route('cancell'),
      ]);
      // dd($response);

      if (isset($response->id) && $response->id != '') {
         session()->put('prod_name', $request->prod_name);
         session()->put('quantity', $request->quantity);
         session()->put('price', $request->price);
         return redirect($response->url);
      } else {
         return redirect()->route('cancell');
      }
      // dd($response);
   }





   // * success response method.





   public function success(Request $request)
   {
      // if (isset($request->session_id)) {

      //    $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
      //    // dd($stripe);
      //    $response = $stripe->checkout->sessions->retrieve($request->session_id);
      //    dd($response);
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
