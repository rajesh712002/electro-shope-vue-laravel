<?php

namespace App\Http\Controllers\admin;

use product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{

    public function category()
    {
        return view('admin.category.categories');
    }

    public function create_cat()
    {
        return view('admin.category.create_category');
    }

    public function store_cat(Request $request)
    {
        //Validation 
        $rules = [
            'name' => 'required|max:50',
            'slug' => 'required|unique:categories|max:100',
            'status' => 'required|max:50'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // return redirect()->route('admin.create_cat')->withInput()->withErrors($validator);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        //store Image
        // $image = $request->image;
        // $ext = $image->Extension();
        // $imagename = time() . '.' . $ext;
        // $image->move(public_path('uploads/products'), $imagename);
        // $category->image = $imagename;

        $category->save();

       // return redirect()->route('admin.category')->with('success', 'Category Added Successfully');
    }

    public function view_subcategory()
    {
        return view('admin.category.subcategory');
    }

    public function create_subcat()
    {
        // $cat = Category::all();
        // return view('admin.category.create_subcategory', ['cat' => $cat]); //['cat'=>$cat]);
        $options = Category::pluck('name', 'id'); 
        return view('admin.category.create_subcategory', compact('options'));


    }
    public function store_subcat(Request $request)
    {
        $rules = [
            'category' => 'required|max:50',
            'name' => 'required|max:50',
            'slug' => 'required|unique:subcategories|max:100',
             'status' => 'required|max:50'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
           //return redirect()->route('admin.create_subcat')->withInput()->withErrors($validator);
           return response()->json(['errors' => $validator->errors()], 422);
        }
        $subcategory = new Subcategory();
        $subcategory->subcate_id = $request->category;
        $subcategory->subcate_name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->status = $request->status;
        //store Image
        // $image = $request->image;
        // $ext = $image->Extension();
        // $imagename = time() . '.' . $ext;
        // $image->move(public_path('uploads/products'), $imagename);
        // $subcategory->image = $imagename;

        $subcategory->save();

        return redirect()->route('admin.create_subcat')->with('success', 'SubCategory Added Successfully');
    }
}
