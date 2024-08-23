@extends('admin.layouts.app')


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid my-2">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Orders</h1>
                    </div>
                    <div class="col-sm-6 text-right">
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
                    <div class="card-header">
                        <div class="card-tools">
                            <div class="input-group input-group" style="width: 250px;">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Search">

                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Orders #</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Total</th>
                                    <th>Date Purchased</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @dd($order) --}}
                                @foreach ($order as $orders)
                                    <tr>
                                        <td><a href="{{ route('admin.orderdetail', $orders->id) }}">{{ $orders->id }}</a>
                                        </td>
                                        <td>{{ $orders->user->name }}</td>
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
                                            @endif
                                            {{-- <span class="badge bg-success">Delivered</span> --}}
                                        </td>
                                        <td>{{$orders->payment_status}}</td>
                                        <td><i class="fa fa-inr" aria-hidden="true"></i> {{ $orders->grand_total }}</td>
                                        <td>{{ \Carbon\Carbon::parse($orders->created_at)->format('d M, Y') }}</td>
                                    </tr>
                                
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer clearfix">
                        <ul class="pagination pagination m-0 float-right">
                            <li class="page-item"><a class="page-link" href="#">«</a></li>
                            <li class="page-item"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">»</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
