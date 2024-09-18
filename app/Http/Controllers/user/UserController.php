<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
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

    public function login()
    {
        return view('user.login');
    }

    public function deshboard()
    {
        $category = Category::withCount('product')->get();
        $product = Product::orderBy('created_at', 'desc')->limit(12)->get();
        return view('user.deshboard', compact('category', 'product'));
    }


    //Store User Information
    public function store(Request $request)
    {
        $rules = [

            'name' => 'required|min:3|max:30',
            'email' => 'required|unique:users|email|max:100',
            'password' => 'required|min:8|max:50',
            'phone' => 'required|min:10|max:10',

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


    public function loginchk(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|max:100',
            'password' => 'required|min:5|max:50'
        ]);

        if (Auth::attempt($validate)) {
            if (Auth::guard('web')->user()->role == 1) {
                return redirect()->route('userindex');
            } else { //else if (Auth::guard('web')->user()->role != 1) {
                return redirect()->route('userlogin')->with('success', 'Either Email or Password Incorrect');
            }
        } else {
            return redirect()->route('userlogin')->with('success', 'Either Email or Password Incorrect');
        }
    }

    public function account()
    {
        return view('user.account');
    }
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return view('user.login');
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
