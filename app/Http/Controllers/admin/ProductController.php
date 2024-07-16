<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product()
    {
        return view('admin.product.product');
    }

    public function store_prod()
    {
        return view('admin.product.create_product');
    }

    public function brand()
    {
        return view('admin.product.brand');
    }

    public function store_brand()
    {
        return view('admin.product.create_brand');
    }
}
