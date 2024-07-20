<?php

namespace App\Http\Controllers\user;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
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
        return view('user.deshboard');
    }


    //Store User Information
    public function store(Request $request)
    {
        $rules = [

            'name' => 'required|min:3|max:30',
            'email' => 'required|max:100',
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
            'password' => 'required|min:8|max:50'
        ]);

        if (Auth::attempt($validate)) {
            if (Auth::guard('web')->user()->role == 1) {
                return redirect()->route('userdeshboard');
            } else {//else if (Auth::guard('web')->user()->role != 1) {
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
        Auth::logout();
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
        return view('user.login');
    }


    public function view_cart()
    {
        return view('user.order.cart');
    }

    public function view_order()
    {
        return view('user.order.my_orders');
    }

    public function wishlist()
    {
        return view('user.order.wishlist');
    }
}
