<?php

namespace App\Http\Controllers\admin;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\DiscountCoupon;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DiscountCouponController extends Controller
{
    public function coupons(Request $request)
    {
        $discount = DiscountCoupon::latest();
        if (!empty($request->get('keyword'))) {
            $discount = $discount->where('name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('code', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('max_uses', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('max_uses_user', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('type', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('discount_amount', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('min_amount', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('status', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('starts_at', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('expires_at', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('description', 'like', '%' . $request->get('keyword') . '%');
        }

        $discount = $discount->paginate(2);

        return response()->json([
            'discount' => $discount->items(),
            'pagination' => $discount->toArray()['links']
        ]);
    }

    public function createCoupon()
    {
        return view('admin.coupon.create-coupon-code');
    }

    public function storeCoupon(Request $request)
    {
        $rules = [
            'code' => 'required|string|max:50|unique:discount_coupons,code',
            'name' => 'nullable|string|max:100',
            'max_uses' => 'nullable|integer|min:1',
            'max_uses_user' => 'nullable|integer|min:1',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'status' => 'required',
            'starts_at' => 'required|date|date_format:Y-m-d H:i:s|after_or_equal:now',
            'expires_at' => 'required|date|after_or_equal:starts_at|date_format:Y-m-d H:i:s',
            'description' => 'nullable|string|max:500',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $discountCoupon = new DiscountCoupon();
        $discountCoupon->code = $request->code;
        $discountCoupon->name = $request->name;
        $discountCoupon->max_uses = $request->max_uses;
        $discountCoupon->max_uses_user = $request->max_uses_user;
        $discountCoupon->type = $request->type;
        $discountCoupon->discount_amount = $request->discount_amount;
        $discountCoupon->min_amount = $request->min_amount;
        $discountCoupon->status = $request->status;
        $discountCoupon->starts_at = $request->starts_at;
        $discountCoupon->expires_at = $request->expires_at;
        $discountCoupon->description = $request->description;
        $discountCoupon->save();
        return response()->json(['success' => 'Coupon Inserted successfully']);
    }

    public function editCoupon($id)
    {
        // dd($id);
        $couponCode = DiscountCoupon::findOrFail($id);
        // dd($couponCode);
        // return view('admin.coupon.update-coupon-code', compact('couponCode'));
        return response()->json(['success'=>'success','couponCode'=>$couponCode]);
    }

    public function updateCoupon(Request $request, $id)
    {
        $discountCoupon = DiscountCoupon::findOrFail($id);
        $rules = [
            'code' => 'required|string|max:50|unique:discount_coupons,code,' . $discountCoupon->id . ',id',
            'name' => 'nullable|string|max:100',
            'max_uses' => 'nullable|integer|min:1',
            'max_uses_user' => 'nullable|integer|min:1',
            'type' => 'required|in:percent,fixed',
            'discount_amount' => 'required|numeric|min:0',
            'min_amount' => 'nullable|numeric|min:0',
            'status' => 'required',
            // 'starts_at' => 'required|date|date_format:Y-m-d H:i:s|after_or_equal:now',
            'expires_at' => 'required|date|after_or_equal:starts_at|date_format:Y-m-d H:i:s',
            'description' => 'nullable|string|max:500',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $discountCoupon->code = $request->code;
        $discountCoupon->name = $request->name;
        $discountCoupon->max_uses = $request->max_uses;
        $discountCoupon->max_uses_user = $request->max_uses_user;
        $discountCoupon->type = $request->type;
        $discountCoupon->discount_amount = $request->discount_amount;
        $discountCoupon->min_amount = $request->min_amount;
        $discountCoupon->status = $request->status;
        $discountCoupon->starts_at = $request->starts_at;
        $discountCoupon->expires_at = $request->expires_at;
        $discountCoupon->description = $request->description;
        $discountCoupon->save();
        return response()->json(['success' => 'Coupon Updated successfully']);
    }

    public function deleteCoupon($id)
    {
        $couponCode = DiscountCoupon::findOrFail($id);
        $couponCode->delete();
        // return redirect()->route('admin.coupons')->with('success', 'Coupon Deleted Successfully');
        return response()->json(['success'=>'Coupon Deleted Successfully']);
    }


    public function removeCoupon(Request $request)
    {
        // Forget the coupon and discount session values
        session()->forget(['coupon_code', 'discount_amount', 'new_total']);

        return response()->json([
            'success' => true,
            'message' => 'Coupon removed successfully',
            'discount_amount' => 0,
            'coupon_code' => ''
        ]);
    }

    public function getCoupons()
    {
        $timezone = 'Asia/Kolkata';
        $currentTime = Carbon::now($timezone);

        $coupons = DB::table('discount_coupons')
            ->where('status', 1)
            ->where('expires_at', '>=', $currentTime)
            ->get();
        return response()->json($coupons);
        // dd($coupons);
    }


    //================================================================================================================================================================
    //Banner

    public function viewBanner(Request $request)
    {
        $banner = Banner::latest();

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');
            $banner = $banner->where('title', 'like', '%' . $keyword . '%')
                ->orWhere('id', 'like', '%' . $keyword . '%');
        }
        $banner = $banner->paginate(2);
        return response()->json([
            'banner' => $banner->items(),
            'pagination' => $banner->toArray()['links']
        ]);
        // return view('admin.coupon.banner', compact('banner'));
    }

    public function createBanner()
    {
        return view('admin.coupon.create-banner');
    }

    public function storeBanner(Request $request)
    {
        $rules = [

            'name' => 'required|string|max:50',
            'status' => 'required',
            'image' => 'required|image',
            'description' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $banner = new Banner();
        $banner->title = $request->name;
        $banner->description = $request->description;
        $banner->status = $request->status;
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $banner->image = $imagename;
        $banner->save();
        return response()->json(['success' => 'Banner Inserted Successfully']);
    }



    public function editBanner($id)
    {
        $banner = Banner::findOrFail($id);
        // return view('admin.coupon.update-banner', compact('banner'));
        return response()->json(['success' => 'Banner Inserted Successfully', 'banner' => $banner]);
    }

    public function updateBanner(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $rules = [

            'name' => 'required|string|max:50',
            'status' => 'required',
            'image' => $request->isMethod('post') ? 'required|image' : 'nullable|image',
            'description' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        // $banner = new Banner();
        $banner->title = $request->name;
        $banner->description = $request->description;
        $banner->status = $request->status;
        if ($request->hasFile('image')) {
            File::delete(public_path('admin_assets/images/' . $banner->image));
            $image = $request->image;
            $ext = $image->Extension();
            $imagename = time() . '.' . $ext;
            $image->move(public_path('admin_assets/images'), $imagename);
            $banner->image = $imagename;
        }
        $banner->save();
        return response()->json(['success' => 'Banner Updated Successfully', 'banner' => $banner]);
    }

    public function deleteBanner($id)
    {
        $banner = Banner::findOrFail($id);

        File::delete(public_path('admin_assets/images/' . $banner->image));

        $banner->delete();
        return response()->json(['success' => 'Item Deleted successfully']);
        // return redirect()->route('admin.viewBanner')->with('success', 'Banner Deleted Successfully');
    }

    public function bannerCursor()
    {
        $banner = Banner::where('status', '1')->orderBy('id', 'desc')->get();
        $banner = $banner->map(function ($item) {
            $item->image_path = asset('admin_assets/images/' . $item->image);
            return $item;
        });
        // dd($banner);
        return response()->json($banner);
    }
}
