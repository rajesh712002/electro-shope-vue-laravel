<!-- Sidebar -->
<div class="sidebar">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Sidebar user (optional) -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

            <li class="nav-item">
                <a href="{{ route('admin.deshboard') }}" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.category') }}" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.subcategory') }}" class="nav-link">
                    <i class="nav-icon fas fa-file-alt"></i>
                    <p>Sub Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.brand') }}" class="nav-link">
                    <svg class="h-6 nav-icon w-6 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <p>Brands</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.product') }}" class="nav-link">
                    <i class="nav-icon fas fa-tag"></i>
                    <p>Products</p>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.viewBanner') }}" class="nav-link">
                    <i class="nav-icon fa fa-window-restore" aria-hidden="true"></i>
                    <p>Banners</p>                   
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.coupons') }}" class="nav-link">
                    {{-- <i class="fas fa-truck nav-icon"></i> --}}
                    <i class="fas fa-percent nav-icon"></i>

                    <p>Coupon Code</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.orders') }}" class="nav-link">
                    <i class="nav-icon fas fa-shopping-bag"></i>
                    <p>Orders</p>
                </a>
            </li>
            {{-- <li class="nav-item">
								<a href="#" class="nav-link">
									<i class="nav-icon  fa fa-percent" aria-hidden="true"></i>
									<p>Discount</p>
								</a>
							</li> --}}
            <li class="nav-item">
                <a href="{{ route('admin.users') }}" class="nav-link">
                    <i class="nav-icon  fas fa-users"></i>
                    <p>Users</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.viewRating') }}" class="nav-link">
                    <i class="nav-icon fa fa-comments"></i>
                    <p>Feedbacks</p>
                </a>
            </li>
            {{-- <li class="nav-item">
                <a href="{{ route('admin.pages') }}" class="nav-link">
                    <i class="nav-icon  far fa-file-alt"></i>
                    <p>Pages</p>
                </a>
            </li> --}}
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
