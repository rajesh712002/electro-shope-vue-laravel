@extends('admin.layouts.app')

<!-- Content Wrapper. Contains page content -->
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Categories</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('admin.create_cat') }}" class="btn btn-primary">New Category</a>
                    </div>
                </div>
            </div>
            {{-- <div class="row d-flex justify-content-center">
                @if (Session::has('success'))
                    <div class="col-md-10 mt-4">
                        <div class="alert alert-success">
                            <b>{{ Session::get('success') }}</b>
                        </div>
                    </div>
                @endif
            </div> --}}
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                @include('admin.message')
                <form>
                    <div class="card">
                        <form method="get" action="">
                        <div class="card-header">
                           
                                <div class="card-tools">
                                    <div class="input-group input-group" style="width: 250px;">
                                        <input type="text" name="keyword" value="{{Request::get('keyword')}}" class="form-control float-right"
                                            placeholder="Search">
    
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card-body table-responsive p-0">
                       
                            <table class="table table-hover text-nowrap" border="2">
                                <tr>
                                    <th>Product ID</th>
                                    {{-- <th>Image</th> --}}
                                    <th>Product Name</th>
                                    <th>Product Slug</th>
                                    <th>Status</th>

                                    <th>Action</th>
                                </tr>
                                <tr>
                                    @if ($category->isNotEmpty())
                                        @foreach ($category as $prod)
                                            <td>{{ $prod->id }}</td>
                                            {{-- <td><img width="50" src="{{ asset('uploads/products/' . $prod->image) }}"
                                                    alt=""></td> --}}
                                            <td>{{ $prod->name }}</td>
                                            <td>{{ $prod->slug }}</td>
                                            <td>
                                                @if ($prod->status == 1)
                                                    <svg class="text-success-500 h-6 w-6 text-success" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                        stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                @endif

                                            </td>

                                            <td>
                                                <a href="{{-- route('product.show',$prod->prod_id) --}}" class="btn btn-success ">Show</a>
                                                <a href="{{ route('admin.edit_cat', $prod->id) }}"
                                                    class="btn btn-primary">Update</a>
                                                <a href="" onclick="deleteProduct({{ $prod->id }});"
                                                    class="btn btn-danger">Delete</a>
                                                <form id="delete-product-form-{{ $prod->id }}" class="delete_cat"
                                                    method="post" action="{{ route('admin.destroy_cat', $prod->id) }}" function="onclick()">
                                                    @csrf
                                                    @method('delete')
                                                    <script src="{{ asset('admin_assets/js/ajx.js') }} " ></script>
                                                </form>
                                <tr></tr>
                                @endforeach
                                @endif
                                </tr>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                           {{$category->links()}}
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
<!-- /.content-wrapper -->
