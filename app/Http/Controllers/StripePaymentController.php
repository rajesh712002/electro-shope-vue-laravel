<?php

namespace App\Http\Controllers;
use Stripe;
// use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class StripePaymentController extends Controller
{
     /**

     * success response method.

     *

     * @return \Illuminate\Http\Response

     */

     public function stripe()

     {
         return view('user.order.checkout');
     }
 
    
 //0205@1234
     /**
 
      * success response method.
 
      *
 
      * @return \Illuminate\Http\Response
 
      */
 
     public function stripePost(Request $request)
 
     {
        // view('user.order.about-us');
 
         Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
         Stripe\Charge::create (params: [
 
                 "amount" => 100 * 100,
 
                 "currency" => "inr",
 
                 "source" => $request->stripeToken,
 
                 "description" => "New Order Payment Recieved Successfully."
 
         ]);
 
      
 
         Session::flash('success', 'Payment successful!');
 
              
 
        //  return redirect()->back();
 
     }
}
