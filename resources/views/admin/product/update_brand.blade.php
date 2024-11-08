@extends('admin.layouts.app')

<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Update Brand</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('admin.brand') }}" class="btn btn-primary">Back</a>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <form method="POST" action="{{ route('admin.update_brand', $brand->id) }}" name="UpdateBrandForm"
                    id="UpdateBrandForm" enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class=" form-control"
                                            value="{{ old('name', $brand->name) }}" placeholder="Category Name">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class=" form-control"
                                            value="{{ old('slug', $brand->slug) }}" placeholder="Slug">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label " for="image">Photo </label>
                                        <input type="file" name="image" id="image" class="form-control form-control-lg">
                                        
                                        @if($brand->image)
                                            <div class="mt-2">
                                                <p>Current Image:</p>
                                                <img src="{{ asset('admin_assets/images/' . $brand->image) }}" alt="Banner Image" width="150">
                                            </div>
                                        @endif
                                        
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class=" form-control">
                                            <option value="">---select---</option>
                                            <option {{($brand->status == 1) ? 'selected' : ''}} value="1">Active</option>
                                            <option {{($brand->status == 0) ? 'selected' : ''}} value="0">Block</option>
                                        </select>
                                        <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" name="submit" id="submit" class="btn btn-primary">Update</button>
                        <button type="reset" id="reset">Cancel</button>

                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
<script src="{{ asset('admin_assets/js/ajx.js') }}"></script>
