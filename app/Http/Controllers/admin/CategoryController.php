<?php

namespace App\Http\Controllers\admin;

use product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator; // Ensure the paginator class is imported

class CategoryController extends Controller
{

    //CATEGORY ===============================================================================================================================================



    public function category(Request $request)
    {
        $categories = Category::latest();

        if (!empty($request->get('keyword'))) {
            $keyword = $request->get('keyword');

            $category = $categories->where('name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%');
        }

        $categories = $categories->paginate(2);

        if ($request->ajax()) {
            $html = '';

            if ($categories->isNotEmpty()) {
                foreach ($categories as $category) {
                    $html .= '<tr>
                        <td>' . $category->id . '</td>
                        <td><img width="100" src="' . asset('admin_assets/images/' . $category->image) . '" alt=""></td>
                        <td>' . $category->name . '</td>
                        <td>' . $category->slug . '</td>
                        <td>' . ($category->status == 1 ? ' <svg class="text-success-500 h-6 w-6 text-success" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>' : '<svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                            </path>
                                                        </svg>') . '</td>
                        <td>
                            <a href="' . route('admin.edit_cat', $category->id) . '">  <svg class="filament-link-icon w-4 h-4 mr-1"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg></a>
                            <a href="#" onclick="deleteProduct(' . $category->id . ');" class="text-danger"><svg wire:loading.remove.delay="" wire:target=""
                                                            class="filament-link-icon w-4 h-4 mr-1"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path ath fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg></a>
                            <form id="delete-product-form-' . $category->id . '" class="delete_cat" method="post" action="' . route('admin.destroy_cat', $category->id) . '">
                                ' . csrf_field() . method_field('delete') . '
                            </form>
                        </td>
                    </tr>';
                }
            } else {
                $html .= '<tr>
                    <td colspan="6" class="text-center">No categories found.</td>
                </tr>';
            }

            return response()->json([
                'data' => $html,
                'pagination' => (string) $categories->links(),
            ]);
        }

        return view('admin.category.categories', ['category' => $categories]);
    }




    public function createCategory()
    {
        return view('admin.category.create_category');
    }

    public function storeCategory(Request $request)
    {
        //Validation 
        $rules = [
            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|unique:categories|max:100',
            'status' => 'required|max:50',
            'image' => 'required|image',

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
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $category->image = $imagename;

        $category->save();

        return response()->json(['success' => 'Catagory Inserted successfully']);
    }


    //UPDATE Category


    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.category.update_category', [
            'category' => $category
        ]);
    }


    public function updateCategory($id, Request $request)
    {
        $category = Category::findOrFail($id);

        File::delete(public_path('admin_assets/images/' . $category->image));
        //Validation 
        $rules = [
            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|max:100|unique:categories,slug,' . $category->id . ',id',
            'status' => 'required|max:50'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            // return redirect()->route('admin.create_cat')->withInput()->withErrors($validator);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        //$category = new Category(); // If We Declare one more time than it insert a NEW Record
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $category->image = $imagename;

        $category->save();

        return response()->json(['success' => 'Catagory Updated successfully']);
    }


    //DELETE Category
    public function destroyCategory($id)
    {
        $category = Category::findOrFail($id);

        File::delete(public_path('admin_assets/images/' . $category->image));

        $category->delete();
        //return response()->json(['message' => 'Item Deleted successfully']);
        return redirect()->route('admin.category')->with('success', 'Catagory Deleted Successfully');
    }





    //SUB-CATEGORY ========================================================================================================================================

    public function viewSubcategory(Request $request)
    {
        // dd($subcategory->toArray());
        $subcategory = Subcategory::with('category')->latest();

        // dd($subcategory);
        if (!empty($request->get('keyword'))) {
           $subcategory->where('subcate_name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('subcate_id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhereHas('category', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('keyword') . '%');
                });
        }

        $subcategory = $subcategory->paginate(4);
// dd($subcategory);
        if ($request->ajax()) {
            $html = '';

            if ($subcategory->isNotEmpty()) {
                foreach ($subcategory as $subcategories) {
                    $html .= '<tr>
                            <td>' . $subcategories->id . '</td>
                            <td><img width="100" src="' . asset('admin_assets/images/' . $subcategories->image) . '" alt=""></td>
                            <td>' . $subcategories->category->name . '</td>
                            <td>' . $subcategories->subcate_name . '</td>
                            <td>' . $subcategories->slug . '</td>
                            <td>' . ($subcategories->status == 1 ? ' <svg class="text-success-500 h-6 w-6 text-success" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                                aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                            </svg>' : '<svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                                fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                                </path>
                                                            </svg>') . '</td>
                            <td>
                                <a href="' . route('admin.edit_subcate', $subcategories->id) . '">  <svg class="filament-link-icon w-4 h-4 mr-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" aria-hidden="true">
                                                                <path
                                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                                </path>
                                                            </svg></a>
                                <a href="#" onclick="deleteProduct(' . $subcategories->id . ');" class="text-danger"><svg wire:loading.remove.delay="" wire:target=""
                                                                class="filament-link-icon w-4 h-4 mr-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" aria-hidden="true">
                                                                <path ath fill-rule="evenodd"
                                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg></a>
                                <form id="delete-product-form-' . $subcategories->id . '" class="delete_cat" method="post" action="' . route('admin.destroy_subcat', $subcategories->id) . '">
                                   ' . csrf_field() . method_field('delete') . '
                                </form>
                            </td>
                        </tr>';
                }
            } 
            else {
                $html .= '<tr>
                        <td colspan="6" class="text-center">No Subcategory found.</td>
                    </tr>';
            }
            // dd($subcategory);
            return response()->json([
                'data' => $html,
                'pagination' => (string) $subcategory,
            ]);
        }
        return view('admin.category.subcategory', data: ['subcategory' => $subcategory]);
    }

    public function createSubcategory()
    {
        // $cat = Category::all();
        // return view('admin.category.create_subcategory', ['cat' => $cat]); //['cat'=>$cat]);
        $options = Category::where('status', 1)->pluck('name', 'id');
        return view('admin.category.create_subcategory', compact('options'));
    }
    public function storeSubcategory(Request $request)
    {
        $rules = [
            'category' => 'required|max:50',
            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|unique:subcategories|max:100',
            'status' => 'required'

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
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $subcategory->image = $imagename;

        $subcategory->save();
        return response()->json(['success' => 'SubCatagory Inserted successfully']);
    }


    //UPDATE 


    public function editSubcategory($id)
    {
        $options = Category::where('status', 1)->pluck('name', 'id');
        $subcategory = Subcategory::findOrFail($id);
        return view('admin.category.update-subcategory', compact('options', 'subcategory'));
    }

    public function updateSubcategory($id, Request $request)
    {
        $subcategory = Subcategory::findOrFail($id);
        File::delete(public_path('admin_assets/images/' . $subcategory->image));
        $rules = [
            'category' => 'required|max:50',
            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|max:100|unique:subcategories,slug,' . $subcategory->id . ',id',
            'status' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            //return redirect()->route('admin.create_subcat')->withInput()->withErrors($validator);
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $subcategory->subcate_id = $request->category;
        $subcategory->subcate_name = $request->name;
        $subcategory->slug = $request->slug;
        $subcategory->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $subcategory->image = $imagename;
        $subcategory->save();
        return response()->json(['success' => 'SubCatagory Updated successfully']);
    }


    //Delete Sub Category

    public function destroySubcategory($id)
    {
        $subcategory = Subcategory::findOrFail($id);

        File::delete(public_path('admin_assets/images/' . $subcategory->image));

        $subcategory->delete();
        //return response()->json(['message' => 'Item Deleted successfully']);
        return redirect()->route('admin.subcategory')->with('success', 'SubCatagory Deleted Successfully');
    }

    //Get Category wise Sub Category

    public function getCategories()
    {
        $category = Category::get();
        return response()->json($category);
    }

    public function getSubcategories($id)
    {
        $subcategory = Subcategory::where('subcate_id', $id)->get();
        return response()->json($subcategory);
    }
}
