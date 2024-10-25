@extends('admin.layouts.app')

@section('content')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6 text-left">
                        <a href="{{ route('usersExcel') }}" class="btn btn-warning">Export Data</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <form method="get" action="" id="searchForm">
                        <div class="card-header">
                            <div class="card-tools">
                                <div class="input-group" style="width: 250px;">
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
                        <table class="table table-hover text-nowrap" border="2" id="userTable">
                            <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                @if ($users->isNotEmpty())
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="3" class="text-center">No users found</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer clearfix">
                        <div class="pagination-container">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script type="text/javascript">
        $('#searchForm').on('submit', function (e) {
            e.preventDefault();
            fetchUsers();
        });

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchUsers(page);
        });

        function fetchUsers(page = 1) {
            let keyword = $('input[name="keyword"]').val();

            $.ajax({
                url: "{{ route('admin.users') }}" + "?page=" + page,
                method: "GET",
                data: { keyword: keyword }, 
                success: function (response) {
                    $('#userTableBody').html(response.data);

                    $('.pagination-container').html(response.pagination);
                }
            });
        }
    </script>
@endsection
