@extends('admin.layouts.app')

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Category</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('admin.category') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <div class="row d-flex justify-content-center">
            @if (Session::has('success'))
                <div class="col-md-10 mt-4">
                    <div class="alert alert-success">
                        <b>{{ Session::get('success') }}</b>
                    </div>
                </div>
            @endif
        </div>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->

            <div class="container-fluid">
                <form action="{{ route('admin.update_cat',$category->id) }}" id="UpdateCatForm" name="UpdateCatForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class=" form-control"
                                            value="{{ old('name',$category->name) }}" placeholder="Category Name">
                                        <h6 style="color: red" class="error"></h6>
                                        <p></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class=" form-control"
                                            value="{{ old('slug',$category->slug) }}" placeholder="Slug">
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class=" form-control"  value="{{ old('status',$category->status) }}">
                                            <option value="">---select---</option>
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
                        <a href="brands.html" class="btn btn-outline-dark ml-3">Cancel</a>
                    </div>
                </form>
            </div>

            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
<script src="{{ asset('admin_assets/js/ajx.js') }}"></script>
