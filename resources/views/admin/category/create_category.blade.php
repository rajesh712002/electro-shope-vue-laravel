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
                        <h1>Create Category</h1>
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
            <div class="overlay">
                <div class="spinner-container">
                    <div class="spinner-border" style="align-" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <form action="{{ route('admin.store_cat') }}" id="CategoryForm" name="CategoryForm"
                    enctype="multipart/form-data">
                    {{-- @csrf --}}
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" id="name" class=" form-control"
                                            value="{{ old('name') }}" placeholder="Category Name">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" id="slug" class=" form-control"
                                            value="{{ old('slug') }}" placeholder="Slug">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label " for="image">Photo </label>
                                        <input type="file" name="image" id="image"
                                            class=" form-control form-control-lg " value="{{ old('image') }}">
                                        <p></p>
                                        <h6 style="color: red" class="error"></h6>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class=" form-control">
                                            <option value="">---select---</option>
                                            <option value="1">Active</option>
                                            <option value="0">Block</option>
                                        </select>
                                        <p></p>
                                        <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="pb-5 pt-3">
                        <button type="submit" id="submit" name="submit" class="btn btn-primary">Create</button>
                        <button type="reset" id="reset">Cancel</button>
                    </div>
                </form>
            </div>

            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
@endsection
<script src="{{ asset('admin_assets/js/ajx.js') }}"></script>
