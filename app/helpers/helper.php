<?php

use App\Mail\RefundOrderAmount;
use App\Models\user;
use App\Models\Order;
use App\Models\Product;
use App\Mail\OrderEmail;
use App\Models\Category;
use App\Mail\CancleOrder;
use Illuminate\Http\Request;
use App\Mail\SendInvoiceEmail;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;


function chechUserLogin()
{
    if (Auth::check()) {
        return $userId = Auth::user()->id;
    } else {
    }
}

function checkUserLogin()
{
    if (Auth::check()) {
        return $userId = Auth::user()->id;
    } else {
    }
}

function getcategory()
{
    return  $category = Category::withCount('product', 'subcategory')->get();
}



function getproduct()
{
    return $product = Product::with('productImages')->orderBy('created_at', 'desc')->limit(12)->get();
}

function cartCount()
{
    if (Auth::check()) {

        $userId = Auth::user()->id;
        return $totalItemCount  = DB::table('carts')
            ->where('user_id', $userId)
            ->count();
    }
}

function orderItemCount()
{
    if (Auth::check()) {

        $userId = Auth::user()->id;
        return $orderItemCount  = DB::table('order_items')
            ->where('user_id', $userId)
            ->count();
    }
}

function productImage($id)
{
    return $product = Product::where('id', $id)->select('image')->get();
}

function sendEmail($orderId)
{
    $order = Order::with('orderItem')->where('id', $orderId)->first();
    $mailData = [
        'subject' => 'Thanks for your order',
        'order' => $order
    ];

    Mail::to($order->email)->send(new OrderEmail($mailData));
    // dd($order);
}

function sendInvoiceEmail($orderId)
{
    $order = Order::with('orderItem')->where('id', $orderId)->first();
    $mailData = [
        'subject' => 'Thanks for your order',
        'order' => $order
    ];

    Mail::to($order->email)->send(new SendInvoiceEmail($mailData));
    // dd($order);
}


function sendCancleOrderEmail($orderId)
{
    $order = Order::with('orderItem')->where('id', $orderId)->first();
    $mailData = [
        // 'subject' => 'Thanks for your order',
        'order' => $order
    ];

    Mail::to($order->email)->send(new CancleOrder($mailData));
    // dd($order);
}

function refundOrderAmount($orderId)
{
    $order = Order::with('orderItem')->where('id', $orderId)->first();
    $mailData = [
        'order' => $order
    ];

    Mail::to($order->email)->send(new RefundOrderAmount($mailData));
}

