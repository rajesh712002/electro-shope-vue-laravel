@extends('admin.layouts.app')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Product</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('admin.product') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <form action="{{ route('admin.update_prod',$product->id) }}" method="POST" id="UpdateProductForm" name="UpdateProductForm" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" name="name" id="name"
                                                    class="@error('name') is-invalid
                                                        @enderror form-control"
                                                    value="{{ old('name',$product->prod_name) }}" placeholder="Product Name">
                                                @error('name')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                                <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="slug">Slug</label>
                                                <input type="text" name="slug" id="slug" class=" form-control"
                                                    value="{{ old('slug',$product->slug) }}" placeholder="Slug">
                                                    <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="description">Description</label>
                                                <textarea name="description" id="description" cols="30" rows="10" value="{{ old('description',$product->description) }}"
                                                    class=" summernote"
                                                    placeholder="Description"></textarea>
                                                    <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Image</h2>
                                    <div id="image" class="dropzone dz-clickable">
                                        <input type="file" name="image" id="image"
                                            class="@error('image') is-invalid
                                        @enderror form-control form-control-lg "
                                            value="{{ old('image',$product->image) }}">
                                        @error('image')
                                            <p class="invalid-feedback">{{ $message }}</p>
                                        @enderror
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>


                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Pricing</h2>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="price">Price</label>
                                                <input type="text" name="price" id="price"
                                                    class="@error('price') is-invalid
                                                      @enderror form-control"
                                                    placeholder="Price" value="{{ old('price',$product->price) }}">
                                                @error('price')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                                <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="compare_price">Compare at Price</label>
                                                <input type="text" name="compare_price" id="compare_price"
                                                    class="form-control" placeholder="Compare Price" value="{{ old('compare_price',$product->compare_price) }}">
                                                <p class="text-muted mt-3">
                                                    To show a reduced price, move the product’s original price into Compare
                                                    at price. Enter a lower value into Price.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Inventory</h2>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="sku">SKU (Stock Keeping Unit)</label>
                                                <input type="text" name="sku" id="sku"
                                                    class="@error('sku') is-invalid
                                                        @enderror form-control"
                                                    value="{{ old('sku',$product->sku) }}" placeholder="sku">
                                                @error('sku')
                                                    <p class="invalid-feedback">{{ $message }}</p>
                                                @enderror
                                                <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <div class="custom-control custom-checkbox">
                                                    <input class="custom-control-input" type="checkbox" id="track_qty"
                                                        name="track_qty" checked>
                                                    <label for="track_qty" class="custom-control-label">Track
                                                        Quantity</label>
                                                        <p></p>
                                                <h6 style="color: red" class="error"></h6>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <input type="number" min="0" name="qty" id="qty"
                                                    class="form-control" placeholder="Qty"  value="{{ old('qty',$product->qty) }}">
                                                    <p></p>
                                                    <h6 style="color: red" class="error"></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product status</h2>
                                    <div class="mb-3">
                                        <select name="status" id="status" class="form-control">
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h2 class="h4  mb-3">Product category</h2>
                                    <div class="mb-3">
                                        <label for="category">Category</label>

                                        <select name="category" id="category" class="form-control">
                                            <option value="">---select---</option>

                                            @foreach ($category as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                    <div class="mb-3">
                                        <label for="sub_category">Sub category</label>
                                        <select name="sub_category" id="sub_category" class="form-control">
                                            <option value="">---select---</option>
                                            
                                            {{-- @foreach ($subcategory as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach --}}
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h2 class="h4 mb-3">Product brand</h2>
                                    <div class="mb-3">
                                        <select name="brand" id="brand" class="form-control">
                                            <option value="">---select---</option>

                                            @foreach ($brand as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="pb-5 pt-3">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
                        <button type="reset" id="reset">Cancel</button> 

                    </div>
                </div>
            </form>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
<script src="{{ asset('admin_assets/js/ajx.js') }}"></script>

