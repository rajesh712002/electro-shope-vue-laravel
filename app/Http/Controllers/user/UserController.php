<?php

namespace App\Http\Controllers\user;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function back()
    {
        return redirect()->back();
    }
    public function register()
    {
        return view('user.register');
    }

    public function index()
    {

        return view('user.index');
    }



    public function dashboard()
    {
        $category = Category::withCount('product')->get();
        $product = Product::orderBy('created_at', 'desc')->limit(12)->get();
        return view('user.deshboard', compact('category', 'product'));
    }


    //Store User Information
    public function storeRegister(Request $request)
    {
        $rules = [

            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email|unique:users|email|max:100',
            'password' => 'required|min:8|max:50',
            'phone' => 'required|digits:10',


        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('register')->withInput()->withErrors($validator);
        }

        $member = new User();
        $member->name = $request->name;
        $member->email = $request->email;
        $member->password = Hash::make($request->password);
        $member->phone = $request->phone;

        $member->save();

        return redirect()->route('userlogin')->with('success', 'Registration  successfully.');
    }





    public function account()
    {
        return view('user.account');
    }





    public function view_order()
    {
        return view('user.order.my_orders');
    }

    public function wishlist()
    {
        return view('user.order.wishlist');
    }

    public function aboutUs()
    {
        return view('user.order.about-us');
    }


    public function contactUs()
    {
        return view('user.order.contact-us');
    }

    public function privacy()
    {
        return view('user.order.privacy');
    }
}
