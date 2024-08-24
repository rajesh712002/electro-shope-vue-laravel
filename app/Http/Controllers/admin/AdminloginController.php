<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Subcategory;
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
        $totaluser = User::count();

        $totalcategory = Category::where('status','1')->count();

        $totalsubcategory = Subcategory::where('status','1')->count();

        $totalbrand =Brand::where('status','1')->count();

        $totalproduct= Product::where('status','1')->count();
        
        $totalearning = Order::sum('grand_total');
       
        $totalorder= Order::count();
        $pending= Order::where('status','pending')->count();
        $processing= Order::whereIn('status',['shipped','out for delivery'])->count();
        $delivered= Order::where('status','delivered')->count();
        $cancelled= Order::where('status','cancelled')->count();



        return view('admin.deshboard',compact('totaluser','totalcategory','totalsubcategory','totalbrand','totalproduct','totalorder','pending','processing','delivered','cancelled','totalearning'));
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
        
        Auth::guard('admin')->logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        
        return view('admin.login');
    }


    public function users(){
        $users = User::all();
        return view('admin.userdata.user',['users' => $users]);
    }

    public function viewOrders(){
        $order = Order::with('user')->get();
        return view('admin.userdata.orders',compact('order'));
   
    }

    public function viewPendingOrders(){
        $order = Order::where('status','pending')->with('user')->get();
        return view('admin.userdata.orders',compact('order'));
   
    }

    public function viewProcessingOrders(){
        $order = Order::whereIn('status',['shipped','out for delivery'])->with('user')->get();
        return view('admin.userdata.orders',compact('order'));
   
    }

    public function viewCancleOrders(){
        $order = Order::where('status','=','cancelled')->with('user')->get();
        return view('admin.userdata.orders',compact('order'));
   
    }

    public function viewDeliveredOrders(){
        $order = Order::where('status','=','delivered')->with('user')->get();
        return view('admin.userdata.orders',compact('order'));

   
    }

    public function viewOrderDetails($id = null){
        $order_item = OrderItem::where('order_id',$id)->with('order')->first();
        $order_item_det = OrderItem::where('order_id',$id)->with('order')->get();
// dd($order_item_count);
        return view('admin.userdata.order_detail',compact('order_item','order_item_det'));
   
    }

    public function updateUserOrder(Request $request,$id = null){
        $order_update = Order::where('id',$id)->update(['status' => $request->status]);
        return redirect()->back();
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
       if (Auth::guard('admin')->user()->role == 2)
        // dd($user);
        if(!Hash::check($request->old_password,$user->password)){
           
            dd($request->old_password,$user->password);
            return response()->json(['error','Your Password is Incorrected']);
           
        }
        User::where('id',$user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return response()->json(['success','Your Password is Changed']);
        
    }
}
