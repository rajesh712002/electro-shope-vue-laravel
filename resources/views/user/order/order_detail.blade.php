@include('user.includes.header')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                    <li class="breadcrumb-item">Settings</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-11 ">
        <div class="container  mt-5">
            <div class="row">
                <div class="col-md-3">
                    
                    @include('user.includes.account_panel')
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Orders</h2>
                        </div>
                         {{-- @dd($order_item_count) --}}

                        <div class="card-body pb-0">
                            <!-- Info -->
                            <div class="card card-sm">
                                <div class="card-body bg-light mb-3">
                                    <div class="row">
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Order No:</h6>
                                            <!-- Text -->
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                                {{ $order->id }}
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">{{$order->status}} date:</h6>
                                            <!-- Text -->
                                            <p class="mb-lg-0 fs-sm fw-bold">
                                                <time datetime="2019-10-01">
                                                    {{ \Carbon\Carbon::parse($order->updated_at)->format('d M, Y')}}
                                                </time>
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Status:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
                                                @if ($order->status == 'pending')
                                                    <button type="button" class="btn btn-info"><span class="fa fa-bars"
                                                            aria-hidden="true"></span> Pending</button>
                                                @elseif($order->status == 'shipped')
                                                    <button type="button" class="btn btn-primary"><span
                                                            class="fa fa-cog fa-spin" aria-hidden="true"></span>
                                                        Shipped!</button>
                                                @elseif($order->status == 'out for delivery')
                                                    <button type="button" class="btn btn-warning"><span
                                                            class="fa fa-cog fa-spin" aria-hidden="true"></span> Out For
                                                        Delivery!</button>
                                                @elseif($order->status == 'delivered')
                                                    <button type="button" class="btn btn-success"><span
                                                            class="fa fa-check-circle" aria-hidden="true"></span>
                                                        Delivered</button>
                                                @elseif($order->status == 'cancelled')
                                                    <td> <button type="button" class="btn btn-danger"> <i
                                                                class="fa fa-close"></i> Cancelled</button></td>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="col-6 col-lg-3">
                                            <!-- Heading -->
                                            <h6 class="heading-xxxs text-muted">Order Amount:</h6>
                                            <!-- Text -->
                                            <p class="mb-0 fs-sm fw-bold">
                                                <i class="fa fa-inr" aria-hidden="true"></i> {{ $order->grand_total }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer p-3">

                            <!-- Heading -->
                            <h6 class="mb-7 h5 mt-4">Order Items ({{$order_item_count}})</h6>

                            <!-- Divider -->
                            <hr class="my-3">

                            <!-- List group -->
                            <ul>
                                {{-- @dd($order_item) --}}
                                @foreach ($order_item as $order_items)
                                    {{-- @dump($order_items) --}}
                                    <li class="list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-4 col-md-3 col-xl-2">
                                                <!-- Image -->
                                                <a href=""> <img
                                                        src="{{ asset('admin_assets/images/' . $order_items->product->image) }}"></a>

                                            </div>
                                            <div class="col">
                                                <!-- Title -->
                                                <a href=""> <img
                                                        style="width: 100px; height: 70px; object-fit: contain ! important"
                                                        src="{{ asset('admin_assets/images/' . $order_items->product->brand->image) }}"></a>
                                                <p class="mb-4 fs-sm fw-bold">

                                                    <a class="text-body" href="product.html">{{ $order_items->name }}
                                                        X
                                                        <b><u><i>{{ $order_items->qty }}</i></u></b> </a> <br>
                                                    <span class="text-muted"><i class="fa fa-inr"
                                                            aria-hidden="true"></i> {{ $order_items->price }}</span>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    {{-- <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-3 col-xl-2">
                                            <!-- Image -->
                                            <a href="#"><img src="images/product-2.jpg" alt="..." class="img-fluid"></a>
                                        </div>
                                        <div class="col">
                                            <!-- Title -->
                                            <p class="mb-4 fs-sm fw-bold">
                                                <a class="text-body" href="#">Suede cross body Bag x 1</a> <br>
                                                <span class="text-muted">$49.00</span>
                                            </p>                                       
                                        </div>
                                    </div>
                                </li>
                                
                                <li class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-4 col-md-3 col-xl-2">
                                            <!-- Image -->
                                            <a href="#"><img src="images/product-3.jpg" alt="..." class="img-fluid"></a>
                                            
                                        </div>
                                        <div class="col">
                                            
                                            <!-- Title -->
                                            <p class="mb-4 fs-sm fw-bold">
                                                <a class="text-body" href="#">Sweatshirt with Pocket</a> <br>
                                                <span class="text-muted">$39.00</span>
                                            </p>
                                            
                                        </div>
                                    </div>
                                </li> --}}
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="card card-lg mb-5 mt-3">
                        <div class="card-body">
                            <!-- Heading -->
                            <h6 class="mt-0 mb-3 h5">Order Total</h6>

                            <!-- List group -->
                            <ul>
                                <li class="list-group-item d-flex">
                                    <span>Subtotal</span>
                                    <span class="ms-auto"><i class="fa fa-inr" aria-hidden="true"></i>
                                        {{ $order->grand_total }} </span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span>Tax</span>
                                    <span class="ms-auto"><i class="fa fa-inr" aria-hidden="true"></i> 0.00</span>
                                </li>
                                <li class="list-group-item d-flex">
                                    <span>Shipping</span>
                                    <span class="ms-auto">Free</span>
                                </li>
                                <li class="list-group-item d-flex fs-lg fw-bold">
                                    <span>Total</span>
                                    <span class="ms-auto"><i class="fa fa-inr" aria-hidden="true"></i>
                                        {{ $order->grand_total }} </span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@include('user.includes.footer')
