@extends('admin.layouts.app')

<!-- Content Wrapper. Contains page content -->
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Banners</h1>
                    </div>
                   
                    <div class="col-sm-6 text-right">
                        <a href="{{ route('admin.createBanner') }}" class="btn btn-primary">New Banner</a>
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
                        <form method="get" action="" id="searchForm">
                            <div class="card-header">

                                <div class="card-tools">
                                    <div class="input-group input-group" style="width: 250px;">
                                        <input type="text" name="keyword" value="{{ Request::get('keyword') }}"
                                            class="form-control float-right" placeholder="Search">

                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="card-body table-responsive p-0" id="userTable">

                            <table class="table table-hover text-nowrap" border="2">
                                <thead>
                                    <tr>
                                        <th>Banner ID</th>
                                        <th>Image</th>
                                        <th>Banner Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="userTableBody">
                                    <tr>
                                        @if ($banner->isNotEmpty())
                                            @foreach ($banner as $banners)
                                                <td>{{ $banners->id }}</td>
                                                <td><img width="100"
                                                        src="{{ asset('admin_assets/images/' . $banners->image) }}"
                                                        alt=""></td>
                                                <td>{{ $banners->title }}</td>
                                                <td>{!! $banners->description !!}</td>
                                                <td>
                                                    @if ($banners->status == 1)
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

                                                    <a href="{{ route('admin.editBanner', $banners->id) }}">
                                                        <svg class="filament-link-icon w-4 h-4 mr-1"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path
                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                            </path>
                                                        </svg>
                                                    </a>

                                                    <a href="#" onclick="deleteProduct({{ $banners->id }});"
                                                        class="text-danger w-4 h-4 mr-1">
                                                        <svg wire:loading.remove.delay="" wire:target=""
                                                            class="filament-link-icon w-4 h-4 mr-1"
                                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" aria-hidden="true">
                                                            <path ath fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                    </a>
                                                    <form id="delete-product-form-{{ $banners->id }}" class="delete_cat"
                                                        method="post" action="{{ route('admin.deleteBanner', $banners->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <script src="{{ asset('admin_assets/js/ajx.js') }} "></script>
                                                    </form>
                                                </td>
                                    <tr></tr>
                                    @endforeach
                                    @endif
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            <div class="pagination-container">
                                {{ $banner->links() }}
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <script>
        function deleteProduct(id) {
            if (confirm("Do you really want to delete this record ?")) {
                document.getElementById("delete-product-form-" + id).submit();
            }
        }
    </script>

    @endsection
<!-- /.content-wrapper -->
