@extends('admin.layouts.app')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
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
                                <th>User ID</th>
                                {{-- <th>Image</th> --}}
                                <th>User Name</th>
                                <th>User Email</th>
                                {{-- <th>Price</th>
                            
                            <th>Action</th> --}}
                            </tr>
                            <tr>
                                @if ($users->isNotEmpty())
                                    @foreach ($users as $user)
                                        @if ($user->role == 1)
                                            <td>{{ $user->id }}</td>

                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>

                            <tr></tr>
                            @endif
                            @endforeach
                            @endif
                            </tr>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
