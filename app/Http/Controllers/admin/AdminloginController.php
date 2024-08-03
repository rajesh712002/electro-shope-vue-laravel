<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

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
        $users = User::all();
        return view('admin.userdata.user',['users' => $users]);
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

    public function aboutus(){
        return view('admin.userdata.contact-us');
    }

    public function straboutus(){
       
    }

    public function changePassword(){
        return view('admin.change-password');
    }

    public function showchangePassword(Request $request){
        $rules = [

            'old_password' => 'required|min:3|max:30',
            'new_password' => 'required|min:3|max:30',
            'confirm_password' => 'required|same:new_password'
           
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            // return redirect()->route('user.changePassword')->withInput()->withErrors($validator);
        }

        $user = User::select('id','password')->where('id', Auth::guard('admin')->user()->id)->first();
       // if (Auth::guard('admin')->user()->role == 2)
        // dd($user);
        // if(!Hash::check($request->old_password,$user->password)){
        //     //session()->flash('error','Your Password is Incorrected');
        //     //dd(session());
        //     return response()->json(['error','Your Password is Incorrected']);
           
        // }
        // User::where('id',$user->id)->update([
        //     'password' => Hash::make($request->new_password)
        // ]);
        return response()->json(['success','Your Password is Changed']);
        
    }
}
