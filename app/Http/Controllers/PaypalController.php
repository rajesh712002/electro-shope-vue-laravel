<?php

namespace App\Http\Controllers;

use Log;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\PayPal as PayPalClient;


//Email Password
// sb-8zart32953483@personal.example.com
// sbvMH3*M

class PaypalController extends Controller
{


    public function paypal(Request $request)
    {
        //   dd( $request->all());

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

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();


        $totalPrice = 0;

        foreach ($request->price as $index => $price) {
            $quantity = $request->quantity[$index];
            $totalPrice += $price * $quantity;
        }
        // dd($totalPrice);
        $items = array_map(function ($price, $name, $quantity) {
            return [
                "name" => $name,
                "unit_amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($price, 2, '.', '')
                ],
                "quantity" => $quantity
            ];
        }, $request->price, $request->prod_name, $request->quantity);


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


        // Calculate item total
        $itemTotal = number_format(array_sum(array_map(function ($price, $quantity) {
            return $price * $quantity;
        }, $request->price, $request->quantity)), 2, '.', '');

        $couponCode = session('coupon_code', null);
        $discountAmount = session('discount_amount', 0);
        $newTotal = session('new_total', $itemTotal);

        // dd($newTotal);


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
                        "value" => number_format($newTotal, 2, '.', ''), // total after discounts
                        "breakdown" => [
                            "item_total" => [
                                "currency_code" => "USD",
                                "value" => number_format($itemTotal, 2, '.', '') // exact item total before discounts
                            ],
                            "discount" => [
                                "currency_code" => "USD",
                                "value" => number_format($discountAmount, 2, '.', '') // discount applied
                            ]
                        ]
                    ],
                    "items" => $items
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

        if ($response['status'] == 'COMPLETED') {
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

            $couponCode = session('coupon_code', null);
            $discount = session('discount_amount', 0);
            $newTotal = session('new_total', $totalSum);
            // Create a new order session
            $orderData = session()->get('order_data');

            // dd($response);

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

            // Create a new order
            $order = new Order();
            $order->subtotal = $totalSum;
            $order->shipping = 0;
            $order->grand_total = $newTotal;
            $order->discount = $discount;
            $order->coupon_code = $couponCode;
            $order->payment_status = 'paid with PayPal';
            $order->payment_id = $response['purchase_units'][0]['payments']['captures'][0]['id'];

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
            session()->forget(['coupon_code', 'discount_amount', 'new_total']);

            // Redirect with success message
            return redirect()->route('user.view_order')->with('status', 'Payment is successful and your order is placed.');
        } else {
            return redirect()->route('cancell')->with('error', 'Payment was not successful.');
        }


        //   return redirect()->route('cancell')->with('error', 'Invalid session ID.');
    }

    public function cancel()
    {

        return redirect()->route('user.index')->with('error', 'Payment Is Unsuccessful.');

        // return "Payment Is Unsuccessful";
    }



   

    public function refund(Request $request, $orderId)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        $accessTokenResponse = $provider->getAccessToken();

        if (is_array($accessTokenResponse)) {
            $accessToken = $accessTokenResponse['access_token'] ?? null;
        } else {
            $accessToken = $accessTokenResponse;
        }

        // dd($accessToken);
        if (!$accessToken) {
            return redirect()->back()->with('error', 'Failed to retrieve PayPal access token.');
        }

        $order = Order::findOrFail($orderId);
        $captureId = $order->payment_id;

        $refundData = [
            'amount' => [
                'currency_code' => 'USD',
                'value' => number_format($order->grand_total, 2, '.', '')
            ]
        ];

        try {
            $response = Http::withToken($accessToken)->post(
                "https://api.sandbox.paypal.com/v2/payments/captures/{$captureId}/refund",
                $refundData
            );

            // dd($response);
            if ($response->successful()) {
                $refund = $response->json();

                if (isset($refund['id']) && $refund['status'] === 'COMPLETED') {
                    $order->status = 'refunded';
                    $order->refund_id = $refund['id'];
                    $order->save();

                    // Mail For Refund
                    refundOrderAmount($orderId);

                    return redirect()->back()->with('status', 'Refund processed successfully.');
                }
            } else {
                $errorMessage = $response->json()['message'] ?? json_encode($response->json());
                return redirect()->back()->with('error', 'Refund failed: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error processing refund: ' . $e->getMessage());
        }
    }
}
