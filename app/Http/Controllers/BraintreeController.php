<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Braintree\Gateway;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BraintreeController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new Gateway([
            'environment' => config('services.braintree.env'),
            'merchantId' => config('services.braintree.merchant_id'),
            'publicKey' => config('services.braintree.public_key'),
            'privateKey' => config('services.braintree.private_key'),
        ]);
    }

    public function braintreeCard(Request $request)
    {
        $rules = [
            // 'first_name' => 'required|string|max:50',
            // 'last_name' => 'required|string|max:50',
            // 'email' => 'required|email|max:50',
            // 'country' => 'required',
            // 'address' => 'required|max:50',
            // 'city' => 'required|string|max:50',
            // 'state' => 'required|string|max:50',
            // 'zip' => 'required|digits_between:3,10',
            // 'mobile' => 'required|digits:10',
        ];

        // Perform validation
        $validator = Validator::make($request->all(), $rules);

        // Return an error if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            // return redirect()->route('user.checkout')->with('status', 'Please Check Detail Correctly And Fill Up Them.');
        }
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
        //  $orderData = session()->get('order_data');
        //  dd($orderData);
 
        $userId =7;// Auth::user()->id;
        $totalSum = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $userId)
            ->select(DB::raw('SUM(carts.qty * products.price) as totalSum'))
            ->pluck('totalSum')
            ->first();
        $newTotal = session('new_total', $totalSum);

        $token = $this->gateway->clientToken()->generate();
        return response()->json(['token' => $token,'totalSum' => $totalSum, 'newTotal' => $newTotal]);
        // return view('user.order.braintree', ['token' => $token], compact('totalSum', 'newTotal'));
    }

    public function braintree(Request $request)
    {
        $orderData = $request->order_data;

        // dd($orderData);

        // $user = Auth::user();
        $userId = 7;//$user->id;
        $totalSum = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', $userId)
            ->select(DB::raw('SUM(carts.qty * products.price) as totalSum'))
            ->pluck('totalSum')
            ->first();

        $discount = session('discount_amount', 0);
        $newTotal = session('new_total', $totalSum);

        $amount = $request->amount; // Get amount from the form request
        $nonce = $request->payment_method_nonce;

        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ],

        ]);
        // dd($result);

        if ($result->success) {

            // $user = Auth::user();
            $userId =7;// $user->id;

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
            $orderData = $request->order_data;

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
            $discount = session('discount_amount', 0);
            $newTotal = session('new_total', $totalSum);

            // Create a new order
            $transactionId = $result->transaction->id;
            // dd($transactionId);
            $order = new Order();
            $order->subtotal = $totalSum;
            $order->shipping = 0;
            $order->grand_total = $amount ?? $newTotal;
            // $order->grand_total = $newTotal;
            $order->discount = $discount;
            $order->coupon_code = $couponCode;

            $order->payment_status = 'paid with BraintreeCard';
            $order->payment_id = $transactionId;
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

            //Update Product Qty
            foreach ($product as $products) {
                $productUpdate = Product::findOrFail($products->id);
                $productUpdate->qty -= $products->cqty;
                $productUpdate->save();
            }

            // Clear the cart after successful payment
            Cart::where('user_id', $userId)->delete();

            // $request->session()->forget('order_data');

            session()->forget(['coupon_code', 'discount_amount', 'new_total']);

            // return redirect()->route('user.view_order')->with('status', 'Payment is successful and your order is placed.');
        } else {
            // return redirect()->route('user.index')->with('error', 'Payment Is Unsuccessful.');
        }
    }


    public function refund(Request $request, $orderId)
    {
        try {
            $order = Order::findOrFail($orderId);

            if (!$order) {
                return redirect()->back()->with('error', 'Order not found.');
            }

            $transactionId = $order->payment_id;

            if (!$transactionId) {
                return redirect()->back()->with('error', 'No transaction ID found for this order.');
            }

            // Create the refund

            $transaction = $this->gateway->transaction()->find($transactionId);

            if ($transaction->status !== 'settled') {
                return redirect()->back()->with('error', 'Cannot refund transaction unless it is settled.');
            }

            $result = $this->gateway->transaction()->refund($transactionId);
            // dd($result);

            if ($result->success) {
                $order->status = 'refunded';
                $order->refund_id = $result->transaction->id;
                $order->save();

                //Mail For Refund
                refundOrderAmount($orderId);
                return response()->json(['status'=> 'Refund Successful!']);
                // return redirect()->back()->with('status', 'Refund Successful!');
            } else {
                return redirect()->back()->with('error', 'Refund failed: ');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error processing refund: ' . $e->getMessage());
        }
    }
}
