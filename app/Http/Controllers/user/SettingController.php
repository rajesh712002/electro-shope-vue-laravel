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
            'new_password' => 'required|different:old_password|min:3|max:30',
            'confirm_password' => 'required|same:new_password'

        ];

        $validator = Validator::make($request->all(), $rules);

        $user = User::select('id', 'password')->where('id', Auth::user()->id)->first();

        $validator->after(function ($validator) use ($request, $user) {
            if (!Hash::check($request->old_password, $user->password)) {
                $validator->errors()->add('old_password', 'Your old password is incorrect.');
            }
        });
        

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
            // return redirect()->route('user.changePassword')->withInput()->withErrors($validator);
        }

        // dd($request->old_password, $user->password, Hash::check($request->old_password, $user->password));
       
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['errors' => 'Your Password is Incorrected'], 422);
        } else {
            User::where('id', $user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            return response()->json(['success', 'Your Password is Changed']);
        }
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

            'name' => 'required|string|min:3|max:30',
            'email' => 'required|email|max:100|unique:users,email,' . $userId . ',id',
            'phone' => 'required|integer|min:10|max:10'
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

        $token = Str::random(60);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now()
        ]);

        // Mail
        $user = User::where('email', $request->email)->first();

        $formData = [
            'token' => $token,
            'user' => $user
        ];
        Mail::to($request->email)->send(new ResetPasswordEmail($formData));

        return redirect()->route('user.forgetPassword')->with('success', 'Please Check your inbox to resest your password');
    }

    public function resestForgetPassword($token)
    {
        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();

        if ($tokenExist == null) {
            return redirect()->back();
        }
        return view('user.order.forgot_password_email', ['token' => $token]);
    }

    public function processForgotPasswordEmail(Request $request)
    {
        $token = $request->token;

        $tokenExist = DB::table('password_reset_tokens')->where('token', $token)->first();

        if ($tokenExist == null) {
            return redirect()->back();
        } else {
            
            $rules = [

                'new_password' => 'required|different:old_password|min:3|max:30',
                'confirm_password' => 'required|same:new_password'
    
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                // return response()->json(['errors' => $validator->errors()], 422);
                return redirect()->back()->withInput()->withErrors($validator);
            }

            $user = User::where('email', $tokenExist->email)->first();
            User::where('id', $user->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
            return redirect()->back()->with('success', 'Password Reset Successfully');
        }
          
    }



    public function view_order()
    {
        $user_id = Auth::user()->id;
        $order = Order::where('user_id', $user_id)->orderBy('id', 'DESC')->get();
        return view('user.order.my_orders', compact('order'));
    }



    public function orderDetail($id = null)
    {
        $user_id = Auth::user()->id;

        $order = Order::where('user_id', $user_id)->where('id', $id)->first();
        // dd($order);
        $order_item = OrderItem::where('order_id', $id)->with('product')->get();
        $order_item_count = OrderItem::where('order_id', $id)->count();

        return view('user.order.order_detail', compact('order', 'order_item', 'order_item_count'));
    }

    public function remove_order($id)
    {
        $product = Order::findOrFail($id);
        $product->status = 'cancelled';
        $product->save();

        sendCancleOrderEmail($id);

        return redirect()->back();
    }
}
