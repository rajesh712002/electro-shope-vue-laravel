<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function product()
    {
        return view('admin.product.product');
    }

    public function create_prod()
    {
        return view('admin.product.create_product');
    }

    public function store_prod(Request $request){
        $rules = [
            'name' => 'required|max:50',
            'description' => 'required|max:200',
            'image' => 'required',
            'price'=>'required|numeric',
            'status' => 'required|max:50'
            
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator) {
            return redirect()->route('admin.create_prod')->withInput()->withErrors($validator);
        }
    }

    public function brand(Request $request)
    {
        $brand = Brand::latest();
        if (!empty($request->get('keyword'))) {
            $brand = $brand->where('name', 'like', '%' . $request->get('keyword') . '%');
            $brand = $brand->paginate(100);
            return view('admin.product.brand', ['brand' => $brand]);
        } else {
            $brand = $brand->paginate(5);
            return view('admin.product.brand', ['brand' => $brand]);
        }
    }
    
    public function create_brand()
    {
        return view('admin.product.create_brand');
    }

    public function store_brand(Request $request)
    {
       
            $rules = [
                
                'name' => 'required|max:50',
                'slug' => 'required|unique:subcategories|max:100'
                
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
            //store Image
            $image = $request->image;
            $ext = $image->Extension();
            $imagename = time() . '.' . $ext;
            $image->move(public_path('admin_assets/images'), $imagename);
            $brand->image = $imagename;
    
            $brand->save();
    
            return response()->json(['success' => 'Brand Inserted successfully']);
          // return redirect()->route('admin.brand')->with('success','Brand Inserted Successfully');
        
       
    }


    public function edit_brand($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.product.update_brand', [
            'brand' => $brand
        ]);
    }

    public function update_brand($id,Request $request)
    {
       
        $brand = Brand::findOrFail($id);
         File::delete(public_path('admin_assets/images/' . $brand->image));
            $rules = [
                
                'name' => 'required|max:50',
                'slug' => 'required|unique:subcategories|max:100',
                'image' => 'required',
                'status' => 'required'
            ];
    
            $validator = Validator::make($request->all(), $rules);
    
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }
            
          
            $brand->name = $request->name;
            $brand->slug = $request->slug;
            $brand->status = $request->status;
           // store Image
            $image = $request->image;
            $ext = $image->Extension();
            $imagename = time() . '.' . $ext;
            $image->move(public_path('admin_assets/images'), $imagename);
            $brand->image = $imagename;
    
            $brand->save();
    
            return response()->json(['success' => 'Brand Updated successfully']);
          // return redirect()->route('admin.brand')->with('success','Brand Inserted Successfully');     
    }


     //DELETE Brand
     public function destroy_brand($id)
     {
         $brand = Brand::findOrFail($id);
 
         File::delete(public_path('admin_assets/images/' . $brand->image));
 
         $brand->delete();
         //return response()->json(['message' => 'Item Deleted successfully']);
      return redirect()->route('admin.brand')->with('success', 'Brand Deleted Successfully');
     }
 

}
