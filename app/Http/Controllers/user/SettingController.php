<?php

namespace App\Http\Controllers\user;

//use DB;
use App\Mail\ResetPasswordEmail;
use session;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\alert;

class SettingController extends Controller
{
    public function changePassword()
    {
        return view('user.order.change-password');
    }

    public function showchangePassword(Request $request)
    {
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

        $user = User::select('id', 'password')->where('id', Auth::user()->id)->first();
        // dd($user);
        if (!Hash::check($request->old_password, $user->password)) {
            //session()->flash('error','Your Password is Incorrected');
            //dd(session());
            return response()->json(['error' => 'Your Password is Incorrected']);
        }
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return response()->json(['success', 'Your Password is Changed']);
    }


    public function account()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return view('user.account', compact('user'));
    }

    public function changeProfile(Request $request)
    {
        $userId = Auth::user()->id;
        $rules = [

            'name' => 'required|min:3|max:30',
            'email' => 'required|max:100|unique:users,email,' . $userId . ',id',
            'phone' => 'required|min:10|max:10'
            // 'address' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            // return redirect()->route('user.changePassword')->withInput()->withErrors($validator);
        }



        $member = User::find($userId);
        $member->name = $request->name;
        $member->email = $request->email;
        $member->phone = $request->phone;

        $member->save();
        return response()->json(['success', 'Your Profile is Updated']);
    }

    public function forgetPassword()
    {
        return view('user.order.forgot_password');
    }

    public function processForgetPassword(Request $request)
    {
        $rules = [


            'email' => 'required|max:100|email|exists:users,email',

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {

            return redirect()->route('user.forgetPassword')->withInput()->withErrors($validator);
        }

       

        return redirect()->route('user.forgetPassword')->with('success', 'Please Check your inbox to resest your password');
    }

    public function resestForgetPassword()
    {
        return view('user.order.forgot_password');
    }



    public function view_order()
    {
        $user_id = Auth::user()->id;
        $order = Order::where('user_id',$user_id)->orderBy('user_id','DESC')->get();
        return view('user.order.my_orders',compact('order'));
    }

    public function orderDetail($id = null){
        $user_id = Auth::user()->id;

        $order = Order::where('user_id',$user_id)->where('id',$id)->first();
        // dd($order);
        $order_item = OrderItem::where('order_id',$id)->with('product')->get();
        $order_item_count = OrderItem::where('order_id',$id)->count();
        
    return view('user.order.order_detail',compact('order','order_item','order_item_count'));
    }

    public function remove_order($id)
    {
        $product = Order::findOrFail($id);
        $product->delete();
        return redirect()->back();
    }
}
