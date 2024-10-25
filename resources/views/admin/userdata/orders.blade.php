@extends('admin.layouts.app')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Orders</h1>
                    </div>
                    <div class="col-sm-6 text-left">
                        <a href="{{ route('ordersExcel') }}" class="btn btn-warning">Export Data</a>
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
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Orders #</th>
                                    <th>Customer</th>
                                    <th>Deleviry Address Customer</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Total</th>
                                    <th>Date Purchased</th>
                                    <th>Refund</th>
                                </tr>
                            </thead>
                            <tbody id="userTableBody">
                                {{-- @dd($order) --}}
                                @foreach ($order as $orders)
                                    <tr>
                                        <td><a style="text-decoration: none;" href="{{ route('admin.orderdetail', $orders->id) }}">{{ $orders->id }}</a>
                                        </td>
                                        <td>{{ $orders->user->name }}</td>
                                        <td>{{ $orders->first_name }} {{ $orders->last_name }} <br> {{ $orders->address }},
                                            {{ $orders->apartment }},{{ $orders->pincode }}<br>
                                            {{ $orders->state }},{{ $orders->city }}<br>

                                        <td>{{ $orders->email }}</td>
                                        <td>{{ $orders->mobile }}</td>
                                        <td>
                                            @if ($orders->status == 'pending')
                                                <button type="button" class="btn btn-info"><span class="fa fa-bars"
                                                        aria-hidden="true"></span> Pending</button>
                                            @elseif($orders->status == 'shipped')
                                                <button type="button" class="btn btn-primary"><span
                                                        class="fa fa-cog fa-spin" aria-hidden="true"></span>
                                                    Shipped!</button>
                                            @elseif($orders->status == 'out for delivery')
                                                <button type="button" class="btn btn-warning"><span
                                                        class="fa fa-cog fa-spin" aria-hidden="true"></span> Out For
                                                    Delivery!</button>
                                            @elseif($orders->status == 'delivered')
                                                <button type="button" class="btn btn-success"><span
                                                        class="fa fa-check-circle" aria-hidden="true"></span>
                                                    Delivered</button>
                                            @elseif($orders->status == 'cancelled')
                                                <button type="button" class="btn btn-danger"> <i class="fa fa-close"></i>
                                                    Cancelled</button>
                                            @elseif($orders->status == 'refunded')
                                                <button type="button" class="btn btn-secondary"> <i
                                                        class="fa fa-coins"></i>
                                                    Refunded</button>
                                            @endif
                                            
                                        </td>
                                        <td>{{ $orders->payment_status }}</td>
                                        <td><i class="fa fa-inr" aria-hidden="true"></i> {{ $orders->grand_total }}</td>
                                        <td>{{ \Carbon\Carbon::parse($orders->created_at)->format('d M, Y') }}</td>
                                        @if ($orders->status == 'cancelled' && $orders->payment_id != '')
                                            @if ($orders->payment_status == 'paid with Stripe Card')
                                                <td>
                                                    <form action="{{ route('refund') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="order_id" value="{{ $orders->id }}">
                                                        <button type="submit" class="btn btn-secondary">Refund</button>
                                                    </form>
                                                </td>
                                            @elseif($orders->payment_status == 'paid with BraintreeCard')
                                                <td>
                                                    <form action="{{ route('braintree.refund', $orders->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-secondary">Refund</button>
                                                    </form>
                                                </td>
                                            @elseif($orders->payment_status == 'paid with PayPal')
                                                <td>
                                                    <form action="{{ route('paypal.refund', $orders->id) }}"
                                                        method="POST" id="refund">
                                                        @csrf
                                                        <button type="submit" class="btn btn-secondary">Refund</button>
                                                    </form>
                                                </td>
                                            @endif
                                        @endif
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <div class="pagination-container">
                        {{ $order->links() }}
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script type="text/javascript">
      document.getElementById("refund").addEventListener("submit", function() {
            document.querySelector(".overlay").style.display = "flex";
        });


        $('#searchForm').on('submit', function(e) {
            e.preventDefault();
            fetchOrders();
        });

        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchOrders(page);
        });

        function fetchOrders(page = 1) {
            let keyword = $('input[name="keyword"]').val();

            $.ajax({
                url: "{{ route('admin.orders') }}" + "?page=" + page,
                method: "GET",
                data: {
                    keyword: keyword
                },
                success: function(response) {
                    $('#userTableBody').html(response.data);

                    $('.pagination-container').html(response.pagination);
                }
            });
        }
    </script>
@endsection
