<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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

    public function brand()
    {
        return view('admin.product.brand');
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
                return redirect()->route('admin.create_brand')->withInput()->withErrors($validator);
            }
            
           
        
       
    }
}
