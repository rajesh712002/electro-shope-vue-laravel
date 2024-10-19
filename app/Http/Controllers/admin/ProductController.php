<?php

namespace App\Http\Controllers\admin;

use App\Models\Brand;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function product(Request $request)
    {


        $product = Product::with('sub_category', 'brand', 'categorys')->latest();
        $orderID = Order::where('');
        // dd($product->toArray());
        if (!empty($request->get('keyword'))) {
            $product = $product->where('prod_name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('category_id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('sub_category_id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('brand_id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('description', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('price', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('qty', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%')
                ->orWhereHas('categorys', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('keyword') . '%');
                })
                ->orWhereHas('sub_category', function ($query) use ($request) {
                    $query->where('subcate_name', 'like', '%' . $request->get('keyword') . '%');
                })
                ->orWhereHas('brand', function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->get('keyword') . '%');
                });
            }

            $product = $product->paginate(7);
            
            if($request->ajax()){
                $html = '';
                if($product->isNotEmpty()){
                    foreach($product as $prod){
                        $html .= '<tr>
                        <td>'.$prod->id.'</td>
                        <td><img width="100" src="' . asset('admin_assets/images/' . $prod->image) . '" alt=""></td>
                        <td>'. $prod->prod_name.'</td>
                        <td>'.$prod->categorys->name.'</td>
                        <td>'.$prod->sub_category->subcate_name.'</td>
                        <td>'.$prod->brand->name.'</td>
                        <td>'.$prod->description.'</td>
                        <td>'.$prod->price.'</td>
                        <td>'.$prod->compare_price.'</td>
                        <td>'.$prod->qty.'</td>
                         <td>' . ($prod->status == 1 ? ' <svg class="text-success-500 h-6 w-6 text-success" fill="none"
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
                                <a href="' . route('admin.edit_prod', $prod->id) . '">  <svg class="filament-link-icon w-4 h-4 mr-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" aria-hidden="true">
                                                                <path
                                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                                </path>
                                                            </svg></a>
                                <a href="#" onclick="deleteProduct(' . $prod->id . ');" class="text-danger"><svg wire:loading.remove.delay="" wire:target=""
                                                                class="filament-link-icon w-4 h-4 mr-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" aria-hidden="true">
                                                                <path ath fill-rule="evenodd"
                                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg></a>
                                <form id="delete-product-form-' . $prod->id . '" class="delete_cat" method="post" action="' . route('admin.destroy_product', $prod->id) . '">
                                   ' . csrf_field() . method_field('delete') . '
                                </form>
                            </td>
                        </tr>';
                    }
                }else{
                    $html = '<tr>
                    <td>No Data Found</td>
                    </tr>';
                }

                return response()->json([
                    'data' => $html,
                    'pagination' => (string) $product
                ]);
            }
            return view('admin.product.product', compact('product'));
        
    }

    public function createProduct()
    {
        $category = Category::where('status', 1)->pluck('name', 'id');
        $subcategory = Subcategory::where('status', 1)->pluck('subcate_name', 'id');
        $brand = Brand::where('status', 1)->pluck('name', 'id');
        return view('admin.product.create_product', compact('category', 'brand', 'subcategory'));
    }

    public function storeProduct(Request $request)
    {
        $rules = [
            'name' => 'required|alpha_num|max:50',
            'description' => 'required',
            'image' => 'required|image',
            'price' => 'required|numeric',
            'status' => 'required',
            'category' => 'required',
            'slug' => 'required|alpha_num',
            'qty' => 'required|numeric',
            'brand' => 'required|alpha_num'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product = new Product();
        $product->prod_name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->sku = $request->sku;
        // $product->track_qty = $request->track_qty;
        $product->qty = $request->qty;
        $product->category_id  = $request->category;
        $product->sub_category_id  = $request->sub_category;
        $product->brand_id  = $request->brand;
        $product->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $product->image = $imagename;

        $product->save();

        return response()->json(['success' => 'Product Inserted successfully']);
    }

    //Update Product


    public function editProduct($id)
    {
        $category = Category::where('status', 1)->pluck('name', 'id');
        $subcategory = Subcategory::where('status', 1)->pluck('subcate_name', 'id');
        $brand = Brand::where('status', 1)->pluck('name', 'id');
        $product = Product::findOrFail($id);
        return view('admin.product.update_product', compact('category', 'brand', 'product', 'subcategory'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        // File::delete(public_path('admin_assets/images/' . $product->image));


        $rules = [
            'name' => 'required|alpha_num|max:50',
            'description' => 'required',
            'image' => 'required|image',
            'price' => 'required|numeric',
            'status' => 'required',
            'category' => 'required',
            'slug' => 'required|alpha_num|unique:products,slug,' . $product->id . ',id',
            'qty' => 'required|numeric',
            'brand' => 'required'

        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $product->prod_name = $request->name;
        $product->slug = $request->slug;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->compare_price = $request->compare_price;
        $product->sku = $request->sku;
        // $product->track_qty = $request->track_qty;
        $product->qty = $request->qty;
        $product->category_id  = $request->category;
        $product->sub_category_id  = $request->sub_category;
        $product->brand_id  = $request->brand;
        $product->status = $request->status;
        //store Image
        $image = $request->image;
        $ext = $image->Extension();
        $imagename = time() . '.' . $ext;
        $image->move(public_path('admin_assets/images'), $imagename);
        $product->image = $imagename;

        $product->save();

        return response()->json(['success' => 'Product Updated successfully']);
    }


    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);

        // File::delete(public_path('admin_assets/images/' . $product->image));

        $product->delete();
        //return response()->json(['message' => 'Item Deleted successfully']);
        return redirect()->route('admin.product')->with('success', 'Product Deleted Successfully');
    }



    //BRANDS =====================================================================================================================

    // public function brand(Request $request)
    // {
    //     $brand = Brand::latest();
    //     if (!empty($request->get('keyword'))) {
    //         $brand = $brand->where('name', 'like', '%' . $request->get('keyword') . '%')
    //             ->orWhere('id', 'like', '%' . $request->get('keyword') . '%');

    //         $brand = $brand->paginate(4);

    //         if ($request->ajax()) {
    //             $html = '';
    //             if ($brand->count() > 0) {
    //                 foreach ($brand as $brands) {
    //                     $html .= '<tr>
    //                     <td>' . $brands->id . '</td>
    //                     <td>' . $brands->name . '</td>
    //                     <td>' . $brands->slug . '</td>
    //                     <td>' . $brands->status . '</td>
    //                 </tr>';
    //                 }
    //             } else {
    //                 $html .= '<tr>
    //                 <td colspan="3" class="text-center">No brand found</td>
    //             </tr>';
    //             }

    //             return response()->json([
    //                 'data' => $html,
    //                 'pagination' => (string) $brand->links(),
    //             ]);
    //         }
    //     }
    //     return view('admin.product.brand', ['brand' => $brand]);
    // }

    public function brand(Request $request)
    {
        // Initialize query
        $brand = Brand::latest();

        // Apply search filter if a keyword is provided
        if (!empty($request->get('keyword'))) {
            $brand = $brand->where('name', 'like', '%' . $request->get('keyword') . '%')
                ->orWhere('id', 'like', '%' . $request->get('keyword') . '%');
        }

        // Paginate the result
        $brand = $brand->paginate(4);

        // Handle AJAX request
        if ($request->ajax()) {
            $html = '';

            // Check if there are any brands
            if ($brand->count() > 0) {  // You can also use !$brand->isEmpty()
                foreach ($brand as $brands) {
                    $html .= '<tr>
                    <td>' . $brands->id . '</td>
                    <td><img width="100" src="' . asset('admin_assets/images/' . $brands->image) . '" alt=""></td>
                    <td>' . $brands->name . '</td>
                    <td>' . $brands->slug . '</td>
                    <td>' . ($brands->status == 1 ? ' <svg class="text-success-500 h-6 w-6 text-success" fill="none"
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
                                                             <a href="' . route('admin.edit_brand', $brands->id) . '">  <svg class="filament-link-icon w-4 h-4 mr-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" aria-hidden="true">
                                                                <path
                                                                    d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                                </path>
                                                            </svg></a>
                                <a href="#" onclick="deleteProduct(' . $brands->id . ');" class="text-danger"><svg wire:loading.remove.delay="" wire:target=""
                                                                class="filament-link-icon w-4 h-4 mr-1"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" aria-hidden="true">
                                                                <path ath fill-rule="evenodd"
                                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                    clip-rule="evenodd"></path>
                                                            </svg></a>
                                <form id="delete-product-form-' . $brands->id . '" class="delete_cat" method="post" action="' . route('admin.destroy_brand', $brands->id) . '">
                                   ' . csrf_field() . method_field('delete') . '
                                </form>
                            </td>
                        
                </tr>';
                }
            } else {
                $html .= '<tr>
                <td colspan="3" class="text-center">No brand found</td>
            </tr>';
            }

            // Return HTML and pagination links
            return response()->json([
                'data' => $html,
                'pagination' => (string) $brand->links(),  // Ensure this is called on the paginated result
            ]);
        }

        // Return the view for non-AJAX requests
        return view('admin.product.brand', ['brand' => $brand]);
    }


    public function createBrand()
    {
        return view('admin.product.create_brand');
    }

    public function storeBrand(Request $request)
    {

        $rules = [

            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|unique:subcategories|max:100',
            'status' => 'required',
            'image' => 'required|image'

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


    public function editBrand($id)
    {
        $brand = Brand::findOrFail($id);
        return view('admin.product.update_brand', [
            'brand' => $brand
        ]);
    }

    public function updateBrand($id, Request $request)
    {

        $brand = Brand::findOrFail($id);
        File::delete(public_path('admin_assets/images/' . $brand->image));
        $rules = [

            'name' => 'required|alpha_num|max:50',
            'slug' => 'required|alpha_num|max:100|unique:brands,slug,' . $brand->id . ',id',
            'image' => 'required|image',
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
    public function destroyBrand($id)
    {
        $brand = Brand::findOrFail($id);

        File::delete(public_path('admin_assets/images/' . $brand->image));

        $brand->delete();
        //return response()->json(['message' => 'Item Deleted successfully']);
        return redirect()->route('admin.brand')->with('success', 'Brand Deleted Successfully');
    }
}
