<?php

namespace App\Http\Controllers\user;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    public function checkout(){
        return view("user.order.checkout");
    }

    public function storeCheckout(Request $request){
        $rules = [
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'email' => 'required|max:50',
            'country' => 'required',
            'address' => 'required|max:50',
            'appartment' => 'required|max:50',
            'city' => 'required|max:50',
            'state' => 'required|max:50',
            'zip' => 'required|max:10',
            'mobile' => 'required|max:10|min:10',
            'order_notes' => 'required|max:50',

            // 'description' => 'required',
            // //'image' => 'required',
            // 'price' => 'required|numeric',
            // 'status' => 'required',
            // // 'category' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    }
}
