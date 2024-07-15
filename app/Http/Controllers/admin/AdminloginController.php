<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminloginController extends Controller
{
    public function index(){
        return view('admin.login');
    }

     public function deshboard(){
        return view('admin.deshboard');
    }

    public function loginchk(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|max:50',
            'password' => 'required|min:3|max:30'
        ]);

        if (Auth::attempt($validate)) {
            return redirect()->route('admindeshboard');
        }
    }
    
}
