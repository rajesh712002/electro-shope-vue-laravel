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
use App\Models\ProductRating;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminloginController extends Controller
{




    public function deshboard()
    {
        $totaluser = User::count();

        $totalcategory = Category::where('status', '1')->count();

        $totalsubcategory = Subcategory::where('status', '1')->count();

        $totalbrand = Brand::where('status', '1')->count();

        $totalproduct = Product::where('status', '1')->count();

        $totalearning = Order::where('status', 'delivered')->sum('grand_total');

        $totalorder = Order::count();
        // $pending = Order::where('status', 'pending')->count();
        // $processing = Order::whereIn('status', ['shipped', 'out for delivery'])->count();
        // $delivered = Order::where('status', operator: 'delivered')->count();
        // $cancelled = Order::where('status', 'cancelled')->count();

        $orders = Order::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $statusCounts = $orders->pluck('total', 'status')->toArray();



        return view('admin.deshboard', compact('totaluser', 'totalcategory', 'statusCounts', 'totalsubcategory', 'totalbrand', 'totalproduct', 'totalorder',  'totalearning'));
    }





    public function users(Request $request)
    {

        $users = User::where('role', 1)->latest();


        if (!empty($request->get('keyword'))) {

            $keyword = $request->get('keyword');

            $users = $users->where(function ($query) use ($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('id', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', 'like', '%' . $keyword . '%');
            });
        }

        $users = $users->paginate(3);

        if ($request->ajax()) {
            $html = '';
            if ($users->isNotEmpty()) {
                foreach ($users as $user) {
                    $html .= '<tr>
                    <td>' . $user->id . '</td>
                    <td>' . $user->name . '</td>
                    <td>' . $user->email . '</td>
                </tr>';
                }
            } else {
                $html .= '<tr>
                <td colspan="3" class="text-center">No users found</td>
            </tr>';
            }

            return response()->json([
                'data' => $html,
                'pagination' => (string) $users->links(),
            ]);
        }

        return view('admin.userdata.user', ['users' => $users]);
    }

    public function viewOrders(Request $request)
    {
        $order = Order::with('user')->latest();
        if (!empty($request->get('keyword'))) {
            $order = $order->where('user_id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('grand_total', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('payment_status', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('status', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('email', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('country', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('address', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('city', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('state', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('pincode', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('first_name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('last_name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('mobile', 'like', '%' . $request->get('keyword') . '%')
                ->orWhereHas('user', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('keyword') . '%');
                });
        }

        $order = $order->paginate(7);

        if ($request->ajax()) {
            $html = '';
            if ($order->isNotEmpty()) {
                foreach ($order as $orders) {
                    $html .= '<tr>
                
                        <td><a  style="text-decoration: none;" href="' . route('admin.orderdetail', $orders->id) . '">' . $orders->id . '</a></td>
                        <td>' . $orders->user->name . '</td>
                       <td>' . $orders->first_name . ' ' . $orders->last_name . '<br>' .
                        $orders->address . ', ' .
                        ($orders->apartment ? $orders->apartment . ', ' : '') .
                        $orders->city . ', ' .
                        $orders->state . ', ' .
                        $orders->pincode . '</td>
                        <td>' . $orders->email . '</td>
                        <td>' . $orders->mobile . '</td>
                         <td>';
                    if ($orders->status == 'pending') {
                        $html .= '<button type="button" class="btn btn-info"><span class="fa fa-bars" aria-hidden="true"></span> Pending</button>';
                    } elseif ($orders->status == 'shipped') {
                        $html .= '<button type="button" class="btn btn-primary"><span class="fa fa-cog fa-spin" aria-hidden="true"></span> Shipped!</button>';
                    } elseif ($orders->status == 'out for delivery') {
                        $html .= '<button type="button" class="btn btn-warning"><span class="fa fa-cog fa-spin" aria-hidden="true"></span> Out For Delivery!</button>';
                    } elseif ($orders->status == 'delivered') {
                        $html .= '<button type="button" class="btn btn-success"><span class="fa fa-check-circle" aria-hidden="true"></span> Delivered</button>';
                    } elseif ($orders->status == 'cancelled') {
                        $html .= '<button type="button" class="btn btn-danger"><i class="fa fa-close"></i> Cancelled</button>';
                    } elseif ($orders->status == 'refunded') {
                        $html .= '<button type="button" class="btn btn-secondary"><i class="fa fa-coins"></i> Refunded</button>';
                    }

                    $html .= '</td>
                        <td>' . $orders->payment_status . '</td>
                        <td>' . $orders->grand_total . '</td>
                        <td>' . \Carbon\Carbon::parse($orders->created_at)->format('d M, Y') . '</td>
                            <td>';

                    if ($orders->status == 'cancelled' && $orders->payment_id != '') {
                        if ($orders->payment_status == 'paid with Stripe Card') {
                            $html .= '<td>
                                        <form action="' . route('refund') . '" method="POST">
                                            ' . csrf_field() . '
                                            <input type="hidden" name="order_id" value="' . $orders->id . '">
                                            <button type="submit" class="btn btn-secondary">Refund</button>
                                        </form>
                                    </td>';
                        } elseif ($orders->payment_status == 'paid with BraintreeCard') {
                            $html .= '<td>
                                        <form action="' . route('braintree.refund', $orders->id) . '" method="POST">
                                            ' . csrf_field() . '
                                            <button type="submit" class="btn btn-secondary">Refund</button>
                                        </form>
                                    </td>';
                        } elseif ($orders->payment_status == 'paid with PayPal') {
                            $html .= '<td>
                                        <form action="' . route('paypal.refund', $orders->id) . '" method="POST">
                                            ' . csrf_field() . '
                                            <button type="submit" class="btn btn-secondary">Refund</button>
                                        </form>
                                    </td>';
                        }
                    }
                    $html .= '</td>
                        </tr>';
                }
            }

            return response()->json([
                'data' => $html,
                'pagination' => (string) $order,
            ]);
        }
        return view('admin.userdata.orders', ['order' => $order]);
    }

    public function viewPendingOrders()
    {
        $order = Order::where('status', 'pending')->with('user')->paginate(7);
        return view('admin.userdata.orders', compact('order'));
    }

    public function viewProcessingOrders()
    {
        $order = Order::whereIn('status', ['shipped', 'out for delivery'])->with('user')->paginate(7);
        return view('admin.userdata.orders', compact('order'));
    }

    public function viewCancleOrders()
    {
        $order = Order::where('status', '=', 'cancelled')->with('user')->paginate(7);
        return view('admin.userdata.orders', compact('order'));
    }

    public function viewDeliveredOrders()
    {
        $order = Order::where('status', '=', 'delivered')->with('user')->paginate(7);
        return view('admin.userdata.orders', compact('order'));
    }

    public function viewRefundedOrders()
    {
        $order = Order::where('status', '=', 'refunded')->with('user')->paginate(7);
        return view('admin.userdata.orders', compact('order'));
    }

    public function viewOrderDetails($id = null)
    {
        $order_item = OrderItem::where('order_id', $id)->with('order')->first();
        $order_item_det = OrderItem::where('order_id', $id)->with('order')->get();
        // dd($order_item_count);
        return view('admin.userdata.order_detail', compact('order_item', 'order_item_det'));
    }

    public function updateUserOrder(Request $request, $id = null)
    {
        $order_update = Order::where('id', $id)->update(['status' => $request->status]);
        return redirect()->back();
    }


    public function pages()
    {
        return view('admin.pages');
    }

    public function store_pages()
    {
        return view('admin.create_page');
    }

    public function aboutus()
    {
        return view('admin.userdata.contact-us');
    }

    public function straboutus() {}

    public function changePassword()
    {
        return view('admin.change-password');
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

        $user = User::select('id', 'password')->where('id', Auth::guard('admin')->user()->id)->first();
        if (Auth::guard('admin')->user()->role == 2)
            // dd($user);
            if (!Hash::check($request->old_password, $user->password)) {

                // dd($request->old_password, $user->password);
                return response()->json(['error', 'Your Password is Incorrected']);
            }
        User::where('id', $user->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        return response()->json(['success', 'Your Password is Changed']);
    }

    public function viewRating(Request $request)
    {
        $rating = ProductRating::with('product')->latest();
        if (!empty($request->get('keyword'))) {
            $rating = $rating->where('product_id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('email', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('username', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('comment', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('rating', 'like', '%' . $request->get('keyword') . '%')
                ->orWhereHas('product', function ($query) use ($request) {
                    $query->where('prod_name', 'like', '%' . $request->get('keyword') . '%');
                });
        }
        $rating = $rating->paginate(4);

        if ($request->ajax()) {
            $html = '';
            if ($rating->isNotEmpty()) {
                foreach ($rating as $ratings) {
                    $html .='<tr>
                        <td><img width="120" src="' . asset('admin_assets/images/' .$ratings->product->image) . '" alt=""></td>
                    <td>'.$ratings->product_id.'</td>
                    <td>'.$ratings->product->prod_name.'</td>
                    <td>'.$ratings->rating .'</td>
                    <td>'.$ratings->username.'</td>
                    <td>'.$ratings->comment .'</td>


                    </tr>';
                }
            }
            else{
                $html = '<tr>
                <td>No Data Found</td>
                </tr>';
            }

            return response()->json([
                'data' => $html,
                'pagination' => (string) $rating
            ]);

        }

        return view('admin.userdata.view_rating', ['rating' => $rating]);

        // dd($rating);
        // return view('admin.userdata.view_rating', compact('rating'));
    }

    public function sendIvoiceToCustomer(Request $request, $orderId)
    {
        // echo "hello";
        sendInvoiceEmail($orderId);

        return redirect()->back()->with('status', 'Order Detail Mail Successfully');
    }
}
