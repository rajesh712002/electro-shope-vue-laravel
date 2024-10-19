@extends('admin.layouts.app')
<!-- Content Header (Page header) -->
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->


    <head>
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
            crossorigin="anonymous"></script>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Admin Panel</title>
        <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('admin_assets/css/css/helper.css') }}" rel="stylesheet">
        {{-- {{ asset('admin_assets/css/adminlte.min.css') }} --}}
        <link href="{{ asset('admin_assets/css/css/style.css') }}" rel="stylesheet">
    </head>

    <body class="fix-header">

        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2"
                    stroke-miterlimit="10" />
            </svg>
        </div>


        <div id="main-wrapper">


            <div class="page-wrapper">

                <div class="container-fluid">
                    <div class="col-lg-12">
                        <div class="card card-outline-primary">
                            <div class="card-header">
                                <h4 class="m-b-0 text-white">Admin Dashboard</h4>
                            </div>
                            <div class="row">

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-th-large f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{ $totalcategory }}</b>
                                                <p class="m-b-0">Categories</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.category') }}" class="small-box-footer text-dark">More info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa fa-qrcode f-s-40"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{ $totalsubcategory }}</b>
                                                <p class="m-b-0">Sub Categories</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.subcategory') }}" class="small-box-footer text-dark">More
                                            info <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-home f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{ $totalproduct }}</b>
                                                <p class="m-b-0">Products</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.product') }}" class="small-box-footer text-dark">More info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-window-maximize f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{ $totalbrand }}</b>
                                                <p class="m-b-0">Total Brands</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.brand') }}" class="small-box-footer text-dark">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-users f-s-40"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{ $totaluser }}</b>
                                                <p class="m-b-0">Users</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.users') }}" class="small-box-footer text-dark">More info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-shopping-cart f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{ $totalorder }}</b>
                                                <p class="m-b-0">Total Orders</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.orders') }}" class="small-box-footer text-dark">More info
                                            <i class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-genderless f-s-70" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{ $statusCounts['pending']?? 0}}</b>
                                                <p class="m-b-0">Pending Orders</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.pendingdorder') }}"
                                            class="small-box-footer text-dark">More info<i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-spinner f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{ ($statusCounts['shipped']?? 0)+($statusCounts['out for delivery']?? 0) }}</b>
                                                <p class="m-b-0">Processing Orders</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.processingorder') }}"
                                            class="small-box-footer text-dark">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-check f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{ $statusCounts['delivered']?? 0 }}</b>
                                                <p class="m-b-0">Delivered Orders</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.deliveredorder') }}"
                                            class="small-box-footer text-dark">More info<i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-times f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{  $statusCounts['cancelled']?? 0 }}</b>
                                                <p class="m-b-0">Cancelled Orders</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.cancleorder') }}"
                                            class="small-box-footer text-dark">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                
                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-coins f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{  $statusCounts['cancelled']?? 0 }}</b>
                                                <p class="m-b-0">Refunded Orders</p>
                                            </div>
                                        </div>
                                        <a href="{{ route('admin.refundedOrder') }}"
                                            class="small-box-footer text-dark">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-inr f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>{{ $totalearning }}</b>
                                                <p class="m-b-0">Total Earnings</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>

                    <script src="{{ asset('admin_assets/js/js/lib/jquery/jquery.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/js/js/lib/bootstrap/js/popper.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/js/js/lib/bootstrap/js/bootstrap.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/js/js/jquery.slimscroll.js') }}"></script>
                    <script src="{{ asset('admin_assets/js/js/sidebarmenu.js') }}"></script>
                    <script src="{{ asset('admin_assets/js/js/lib/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/js/js/custom.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/plugins/jquery/jquery.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/js/adminlte.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/js/demo.js') }}"></script>
                </div>
            </div>
    </body>
@endsection
