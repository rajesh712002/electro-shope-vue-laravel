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

            {{-- <div class="header">
                <nav class="navbar top-navbar navbar-expand-md navbar-light">

                    <div class="navbar-header">
                        <a class="navbar-brand" href="dashboard.php">

                            <span><img src="images/icnpng" alt="Dashboard" class="dark-logo" /></span>
                        </a>
                    </div>

                    <div class="navbar-collapse">
                        <ul class="navbar-nav mr-auto mt-md-0">
                        </ul>




                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><img src="images/bookingSystem/user-icn.png"
                                    alt="user" class="profile-pic" /></a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        </ul>
                    </div>
                </nav>
            </div> --}}

            {{-- <div class="left-sidebar">

                <div class="scroll-sidebar">

                    <nav class="sidebar-nav">
                        <ul id="sidebarnav">
                            <li class="nav-devider"></li>
                            <li class="nav-label">Home</li>
                            <li> <a href="dashboard.php"><i class="fa fa-tachometer"></i><span>Dashboard</span></a>
                            </li>
                            <li class="nav-label">Log</li>
                            <li> <a href="all_users.php"> <span><i class="fa fa-user f-s-20 "></i></span><span>Users</span></a></li>
                            <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-archive f-s-20 color-warning"></i><span class="hide-menu">Categories</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="all_subcategory.php">All Categories</a></li>
                                    <li><a href="add_category.php">Add Category</a></li>
                                    <li><a href="add_subcategory.php">Add SubCategory</a></li>

                                </ul>
                            </li>
                            <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-archive f-s-20 color-warning" aria-hidden="true"></i><span class="hide-menu">Menu</span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="all_menu.php">All Menues</a></li>
                                    <li><a href="add_menu.php">Add Menu</a></li>


                                </ul>
                            </li>
                            <li> <a href="all_orders.php"><i class="fa fa-shopping-cart" aria-hidden="true"></i><span>Orders</span></a></li>

                        </ul>
                    </nav>

                </div>

            </div> --}}

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
                                        <a href="{{route('admin.category')}}" class="small-box-footer text-dark">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
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
                                        <a href="{{route('admin.subcategory')}}" class="small-box-footer text-dark">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
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
                                        <a href="{{route('admin.product')}}" class="small-box-footer text-dark">More info <i
                                            class="fas fa-arrow-circle-right"></i></a>
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
                                        <a href="{{route('admin.brand')}}" class="small-box-footer text-dark">More info <i
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
                                        <a href="{{ route('admin.users') }}" class="small-box-footer text-dark">More info <i
                                                class="fas fa-arrow-circle-right"></i></a>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card p-30">
                                        <div class="media">
                                            <div class="media-left meida media-middle">
                                                <span><i class="fa fa-shopping-cart f-s-40" aria-hidden="true"></i></span>
                                            </div>
                                            <div class="media-body media-text-right">
                                                <b>77</b>
                                                <p class="m-b-0">Total Orders</p>
                                            </div>
                                        </div>
                                        <a href="{{route('admin.orders')}}" class="small-box-footer text-dark">More info <i
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
                                                <b>7</b>
                                                <p class="m-b-0">Processing Orders</p>
                                            </div>
                                        </div>
                                        <a href="{{route('admin.orders')}}" class="small-box-footer text-dark">More info <i
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
                                                <b>7</b>
                                                <p class="m-b-0">Delivered Orders</p>
                                            </div>
                                        </div>
                                        <a href="{{route('admin.orders')}}" class="small-box-footer text-dark">More info <i
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
                                                <b>7</b>
                                                <p class="m-b-0">Cancelled Orders</p>
                                            </div>
                                        </div>
                                        <a href="{{route('admin.orders')}}" class="small-box-footer text-dark">More info <i
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
                                                <b>710000</b>
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
                   
                    <script src="{{ asset('admin_assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/js/adminlte.min.js') }}"></script>
                    <script src="{{ asset('admin_assets/js/demo.js') }}"></script>
                </div>
            </div>
    </body>
@endsection
