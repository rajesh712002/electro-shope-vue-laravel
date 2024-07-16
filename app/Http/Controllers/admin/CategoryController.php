<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function category()
    {
        return view('admin.category.categories');
    }

    public function store_cat(Request $request)
    {
        //Validation 
        $rules = [
            'name' => 'required|min:1|max:50',
            'slug' => 'required|unique:categories|max:100',


        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator) {
            return view('admin.category.create_category');
        } else {
            return view('admin.login');
        }
    }

    public function subcategory()
    {
        return view('admin.category.subcategory');
    }

    public function store_subcat()
    {
        return view('admin.category.create_subcategory');
    }
}
