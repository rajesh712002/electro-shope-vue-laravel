<?php

namespace App\Http\Controllers;

use App\Models\Cart;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    public function paypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        // $response = $provider->createOrder([
        //     "intent" => "CAPTURE",
        //     "application_context" => [
        //         "return_url" => route('success'),
        //         "cancel_url" => route('cancel')
        //     ],
        //     "purchase_units" => [
        //         [
        //             "amount" => [
        //                 "currency_code" => "USD",
        //                 "value" => $request->price
        //             ]
        //         ]
        //     ]
        // ]);

        $totalPrice = 0;

        foreach ($request->price as $index => $price) {
            $quantity = $request->quantity[$index]; // Get the quantity for the current index
            $totalPrice += $price * $quantity;
        }

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('success'),
                "cancel_url" => route('cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => number_format($totalPrice, 2, '.', '')
                    ],
                    "items" => array_map(function ($price, $name, $quantity) {
                        return [
                            "name" => $name,
                            "unit_amount" => [
                                "currency_code" => "USD",
                                "value" => number_format($price, 2, '.', '')
                            ],
                            "quantity" => $quantity
                        ];
                    }, $request->price, $request->prod_name, $request->quantity)
                ]
            ]
        ]);


        // dd($response);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    session()->put('prod_name', $request->prod_name);
                    session()->put('quantity', $request->quantity);
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('cancel');
        }
    }

    public function success(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        // dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
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
        } else {
            return redirect()->route('cancel');
        }
    }

    public function cancel()
    {

        return redirect()->route('user.index')->with('status', 'Payment Is Unsuccessful.');

        // return "Payment Is Unsuccessful";
    }
}
