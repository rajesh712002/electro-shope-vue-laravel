{{-- @include('user.includes.header') --}}

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?php echo !empty($title) ? 'Title-' . $title : 'Home'; ?></title>
    <meta name="description" content="" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1, user-scalable=no" />

    <meta name="HandheldFriendly" content="True" />
    <meta name="pinterest" content="nopin" />

    <meta property="og:locale" content="en_AU" />
    <meta property="og:type" content="website" />
    <meta property="fb:admins" content="" />
    <meta property="fb:app_id" content="" />
    <meta property="og:site_name" content="" />
    <meta property="og:title" content="" />
    <meta property="og:description" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="" />
    <meta property="og:image:height" content="" />
    <meta property="og:image:alt" content="" />

    <meta name="twitter:title" content="" />
    <meta name="twitter:site" content="" />
    <meta name="twitter:description" content="" />
    <meta name="twitter:image" content="" />
    <meta name="twitter:image:alt" content="" />
    <meta name="twitter:card" content="summary_large_image" />
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('user_assets/css/video-js.css') }}">
    {{-- <link rel="stylesheet" type="text/css" href="css/style.css?v=<?php echo rand(111, 999); ?>" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;500&family=Raleway:ital,wght@0,400;0,600;0,800;1,200&family=Roboto+Condensed:wght@400;700&family=Roboto:wght@300;400;700;900&display=swap"
        rel="stylesheet">

    <!-- Fav Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="#" />
</head>
{{-- @dd($order) --}}
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<main>
    {{-- <form action="" method="GET"> --}}
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                {{-- @dd($product) --}}
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('userindex') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('usershop') }}">Shop</a></li>
                    <li class="breadcrumb-item">{{ $product->prod_name }}</li>
                </ol>
            </div>
        </div>
    </section>
    {{-- @dd($product) --}}
    <section class="section-7 pt-3 mb-3">
        <div class="container">

            <div class="row ">
                <div class="col-md-5">
                    <img style="width: 100px; height: 70px; object-fit: contain !important"
                        src="{{ asset('admin_assets/images/' . $product->brand->image) }}">
                    <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">

                        @if ($images->count() > 0)
                            <div class="carousel-inner bg-light">
                                @foreach ($images as $key => $image)
                                    <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                        <img class=""
                                            src="{{ asset('admin_assets/images/' . $image->images) }}"
                                            alt="{{ $image->images }} image {{ $key + 1 }}">
                                    </div>
                                @endforeach
                            </div>
                            <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                                <i class="fa fa-2x fa-angle-left text-dark"></i>
                            </a>
                            <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                                <i class="fa fa-2x fa-angle-right text-dark"></i>
                            </a>
                        @else
                            {{-- @dd($product->image) --}}
                            <div class="carousel-inner">
                                <div class="carousel-inner bg-light">
                                    <img class=""
                                        src="{{ asset('admin_assets/images/' . $product->image) }}"
                                        alt="">
                                </div>
                            </div>
                        @endif
                    </div>
                </div>


                <div class="col-md-7">
                    <div class="bg-light right">
                       

                        <h1>{{ $product->prod_name }}</h1>
                        <div class="d-flex mb-3">

                            @if ($ratingcount > 0)
                                <div class="text-primary mr-2"
                                    title="{{ (($ratingsum / $ratingcount) * 100) / 5 }}%">
                                    <div class="back-stars">
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>

                                        <div class="front-stars"
                                            style="width:{{ (($ratingsum / $ratingcount) * 100) / 5 }}%">
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                            <i class="fa fa-star" aria-hidden="true"></i>
                                        </div>
                                    </div>
                            @endif
                        </div>
                        <small class="pt-1">({{ $ratingcount }}
                            Reviews)</small>
                    </div>
                    <div>
                        {{-- <img style="10px" src="{{ asset('admin_assets/images/' . $product->brand->image) }}"> --}}
                    </div>
                    <h2 class="price text-secondary"><i class="fa fa-inr"
                            aria-hidden="true"><del>{{ $product->compare_price }}</del></i></h2>
                    <h2 class="price "><i class="fa fa-inr" aria-hidden="true">{{ $product->price }}</i>
                    </h2>
                    {{-- @dd(Auth::user()->id) --}}
                    <p>{!! $product->description !!}</p>

                    <form action="{{ route('user.addToCart') }}" method="POST">
                        {{-- @dd($product) --}}
                        @csrf
                        <input type="hidden" name="prod_id" value="{{ $product->id }}" />
                        <input type="hidden" name="user_id" value="{{ checkUserLogin() }}" />
                        <input type="hidden" name="qty" value="1" />
                        <input type="hidden" name="price" value="{{ $product->price }}" />
                        <input type="hidden" name="name" value="{{ $product->prod_name }}" />
                        <input type="hidden" name="image" value="{{ $product->image }}" />
                        <input type="hidden" name="max_qty" value="{{ $product->qty }}" />
                        <button type="submit" class="btn btn-dark"><i class="fas fa-shopping-cart"></i>
                            &nbsp;ADD TO CART</button>
                    </form>


                </div>
                {{-- @dd($order->product_id == $product->id) --}}
                <br>
                <br>
                <div class="col-md-12 mt-5">
                    <div class="bg-light">
                        <br><br>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                    data-bs-target="#description" type="button" role="tab"
                                    aria-controls="description" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="shipping-tab" data-bs-toggle="tab"
                                    data-bs-target="#shipping" type="button" role="tab"
                                    aria-controls="shipping" aria-selected="false">Shipping & Returns</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="reviews-tab" data-bs-toggle="tab"
                                    data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews"
                                    aria-selected="false">Reviews</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="description" role="tabpanel"
                                aria-labelledby="description-tab">
                                <p>
                                    {!! $product->description !!}
                                </p>
                            </div>
                            <div class="tab-pane fade" id="shipping" role="tabpanel"
                                aria-labelledby="shipping-tab">
                                <p>After Shipping Your Order You Will No Able To Cancle Your Order </p>
                            </div>

                            <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">

                                {{-- @if ($order && $order->prod_id == $product->id) --}}

                                <div class="col-md-8">
                                    @if (checkUserLogin())
                                        <form method="POST" action="{{ route('usersaveRating', $product->id) }}"
                                            id="ProductRatingForm" name="ProductRatingForm">
                                            @csrf
                                            <div class="row">
                                                <h3 class="h4 pb-3">Write a Review</h3>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label for="name">Name</label>
                                                    <input type="text" class="form-control" name="name"
                                                        id="name" placeholder="Name">
                                                    <p></p>
                                                    <h6 style="color: red" class="error"></h6>
                                                </div>
                                                <div class="form-group col-md-6 mb-3">
                                                    <label for="email">Email</label>
                                                    <input type="email" class="form-control" name="email"
                                                        id="email" placeholder="Email">
                                                    <p></p>
                                                    <h6 style="color: red" class="error"></h6>

                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="rating">Rating</label>
                                                    <br>
                                                    <div class="rating" style="width: 10rem" name="rating">
                                                        <input id="rating-5" type="radio" name="rating"
                                                            value="5" /><label for="rating-5"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-4" type="radio" name="rating"
                                                            value="4" /><label for="rating-4"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-3" type="radio" name="rating"
                                                            value="3" /><label for="rating-3"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-2" type="radio" name="rating"
                                                            value="2" /><label for="rating-2"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <input id="rating-1" type="radio" name="rating"
                                                            value="1" /><label for="rating-1"><i
                                                                class="fas fa-3x fa-star"></i></label>
                                                        <p></p>
                                                        <h6 style="color: red" class="error"></h6>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="">How was your overall experience?</label>
                                                    <textarea name="comment" id="comment" class="form-control" cols="30" rows="10"
                                                        placeholder="How was your overall experience?"></textarea>
                                                    <p></p>
                                                    <h6 style="color: red" class="error"></h6>
                                                </div>
                                                <div>
                                                    <button type="submit" id="submit"
                                                        class="btn btn-dark">Submit</button>
                                                </div>

                                            </div>
                                        </form>
                                    @endif
                                </div>

                                <div class="col-md-12 mt-5">
                                    <div class="overall-rating mb-3">
                                        @if ($ratingcount > 0)
                                            <div class="d-flex">
                                                <h1 class="h3 pe-3">{{ number_format($ratingsum / $ratingcount, 1) }}
                                                </h1>
                                                <div class="star-rating mt-2"
                                                    title="{{ (($ratingsum / $ratingcount) * 100) / 5 }}%">
                                                    <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>

                                                        <div class="front-stars"
                                                            style="width:{{ (($ratingsum / $ratingcount) * 100) / 5 }}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{-- @if ($productrat->product_id == $product->id) --}}

                                                <div class="pt-2 ps-2">({{ $ratingcount }}
                                                    Reviews)</div>
                                            </div>
                                        @endif
                                    </div>
                                    {{-- @dd($productrat) --}}
                                    <div class="rating-group mb-4">
                                        @foreach ($productrat as $productratt)
                                            @if ($productratt->product_id == $product->id)
                                                <span> <strong>{{ $productratt->username }}</strong></span>
                                                <div class="star-rating mt-2"
                                                    title="{{ ($productratt->rating * 100) / 5 }}%">
                                                    <div class="back-stars">
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>
                                                        <i class="fa fa-star" aria-hidden="true"></i>

                                                        <div class="front-stars"
                                                            style="width: {{ ($productratt->rating * 100) / 5 }}%">
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                            <i class="fa fa-star" aria-hidden="true"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="my-3">
                                                    <p>{{ $productratt->comment }}

                                                    </p>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>


                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('user_assets/js/ajx.js') }}"></script>

</main>





@include('user.includes.footer')
