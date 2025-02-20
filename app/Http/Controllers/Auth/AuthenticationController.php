<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function userLogin()
    {
        return view('user.login');
    }

    public function userLoginCheck(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|min:5|max:50'
        ]);

        //check user
        if (Auth::attempt($validate)) {
            if (Auth::guard('web')->user()->role == 1) {

                //call below function after login
                $this->svaeGuestCart();

                return redirect()->route('userindex');
            } else { //else if (Auth::guard('web')->user()->role != 1) {
                return redirect()->route('userlogin')->with('success', 'Either Email or Password Incorrect');
            }
        } else {
            return redirect()->route('userlogin')->with('success', 'Either Email or Password Incorrect');
        }
    }

    //Insert Guest session Item in cart after login
    public function svaeGuestCart()
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $guestCart = session()->get('cart', []);

            foreach ($guestCart as $key => $item) {
                // Check if the item already exists in the user cart.
                $existingCartItem = Cart::where('user_id', $userId)
                    ->where('product_id', $key)
                    ->first();

                if ($existingCartItem) {
                    // If the item exists, update the quantity.
                    $newQty = $existingCartItem->qty + $item['qty'];
                    $existingCartItem->qty = min($newQty, $item['max_qty']);
                    $existingCartItem->save();
                } else {
                    // If the item does not exist than  create a new cart item.
                    Cart::create([
                        'user_id'    => $userId,
                        'product_id' => $key,
                        'qty'   => $item['qty'],
                    ]);
                }
            }

            session()->forget('cart');
        } else {
            return "Not Saved";
        }
    }

    //User Logout
    public function userLogout(Request $request)
    {
        Auth::guard('web')->logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect()->route('userindex');
    }



    //=======//============//
    //Admin

    public function adminLogin()
    {
        return view('admin.login');
    }

    
    public function adminLogincheck(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
            'password' => 'required|min:8|max:50'
        ]);
    
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $admin = Auth::guard('admin')->user();
    
            if ($admin->role == 2) {
                return response()->json(['success' => 'Welcome Admin!'], 200);
            } else {
                return response()->json(['message' => 'Either Email or Password is Incorrect'], 401);
            }
        }
    
        return response()->json(['message' => 'Either Email or Password is Incorrect'], 401);
    }
    


    public function adminLogout(Request $request)
    {

        Auth::guard('admin')->logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return response()->json(['success'=>'SuccessFully LogOut']);
        // return view('admin.login');
    }
}
