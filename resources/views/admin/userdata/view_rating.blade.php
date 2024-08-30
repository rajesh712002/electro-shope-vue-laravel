@extends('admin.layouts.app')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Feedbacks</h1>
                    </div>
                    <div class="col-sm-6 text-right">
                        {{-- <a href="create-user.html" class="btn btn-primary">New User</a> --}}
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="container-fluid">
                <div class="card">
                    <form method="get" action="">
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
                    <div class="card-body table-responsive p-0">


                        <table class="table table-hover text-nowrap" border="2">
                            <tr>
                                <th>Image</th>
                                <th>Product ID</th>
                                <th>Product Name</th>
                                <th>Rating</th>
                                <th>Rated By</th>
                                <th>Comment</th>
                                {{-- <t     h></t> --}}

                                {{-- <th>Action</th> --}}
                            </tr>
                            <tr>
                                @if ($rating->isNotEmpty())
                                    @foreach ($rating as $ratings)
                                        <td><img src="{{ asset('admin_assets/images/' . $ratings->product->image) }}" width="120"
                                                height="120"></td>
                                        <td>{{ $ratings->product_id }}</td>
                                        <td>{{ $ratings->product->prod_name }}</td>
                                        <td>{{ $ratings->rating }}</td>
                                        <td>{{ $ratings->username }}</td>
                                        <td>{{ $ratings->comment }}</td>

                            <tr></tr>
                            @endforeach
                            @endif
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                      {{$rating->links()}}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>

@endsection
