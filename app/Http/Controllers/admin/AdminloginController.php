<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminloginController extends Controller
{
    public function index()
    {
        return view('admin.login');
    }

    public function deshboard()
    {
        return view('admin.deshboard');
    }

    public function loginchk(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|max:100',
            'password' => 'required|min:8|max:50'
        ]);

        if (Auth::guard('admin')->attempt($validate)) {
            if (Auth::guard('admin')->user()->role == 2) {
                return redirect()->route('admin.deshboard')->with('success', 'Welcome admin');
            }
             else {//else if (Auth::guard('admin')->user()->role != 2) 
                return redirect()->route('admin.login')->with('success', 'Either Email or Password Incorrect');
            }
        } else {
            return redirect()->route('admin.login')->with('success', 'Either Email or Password Incorrect');
        }
    }

    public function logout(Request $request)
    {
        
        Auth::logout();
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
        
        return view('admin.login');
    }


    public function users(){
        return view('admin.userdata.user');
    }

    public function orders(){
       
        return view('admin.userdata.orders');
   
    }


    public function pages(){
        return view('admin.pages');
    }

    public function store_pages(){
        return view('admin.create_page');
    }
}
