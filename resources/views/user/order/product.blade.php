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

<main>
    <form action="" method="GET">
        <section class="section-5 pt-3 pb-3 mb-3 bg-white">
            <div class="container">
                <div class="light-font">
                    {{-- @dd($product) --}}
                    <ol class="breadcrumb primary-color mb-0">
                        <li class="breadcrumb-item"><a class="white-text" href="{{route('userindex')}}">Home</a></li>
                        <li class="breadcrumb-item"><a class="white-text" href="{{route('usershop')}}">Shop</a></li>
                        <li class="breadcrumb-item">{{ $product->prod_name }}</li>
                    </ol>
                </div>
            </div>
        </section>

        <section class="section-7 pt-3 mb-3">
            <div class="container">

                <div class="row ">
                    <div class="col-md-5">
                        <div id="product-carousel" class="carousel slide" data-bs-ride="carousel">
                            <div class="carousel-inner bg-light">
                                <div class="carousel-item" style="display: block " >
                                    <img class="w-100 h-100" src="{{ asset('admin_assets/images/' . $product->image) }}"
                                        alt="">
                                </div>

                                {{-- <div class="carousel-item active">
                                <img class="w-100 h-100" src="images/product-2.jpg" alt="Image">
                                </div>
                                <div class="carousel-item">
                                    <img class="w-100 h-100" src="images/product-3.jpg" alt="Image">
                                </div>
                                <div class="carousel-item">
                                    <img class="w-100 h-100" src="images/product-4.jpg" alt="Image">
                                </div> --}}
                            </div>
                            {{-- <a class="carousel-control-prev" href="#product-carousel" data-bs-slide="prev">
                                <i class="fa fa-2x fa-angle-left text-dark"></i>
                            </a>
                            <a class="carousel-control-next" href="#product-carousel" data-bs-slide="next">
                                <i class="fa fa-2x fa-angle-right text-dark"></i>
                            </a> --}}
                        </div>
                    </div>
                    {{-- <img width="10" src="{{ asset('admin_assets/images/' . $product->brand->image) }}"> --}}
                    <div class="col-md-7">
                        <div class="bg-light right">
                            <img style="width: 100px; height: 70px; object-fit: contain;!important" src="{{ asset('admin_assets/images/' . $product->brand->image) }}">
                            <h1>{{ $product->prod_name }}</h1>
                            <div class="d-flex mb-3">
                                <div class="text-primary mr-2">
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star"></small>
                                    <small class="fas fa-star-half-alt"></small>
                                    <small class="far fa-star"></small>
                                </div>
                                <small class="pt-1">(99 Reviews)</small>
                            </div>
                          <div>
                            {{-- <img style="10px" src="{{ asset('admin_assets/images/' . $product->brand->image) }}"> --}}
                          </div>
                            <h2 class="price text-secondary"><i class="fa fa-inr"
                                    aria-hidden="true"><del>{{ $product->compare_price }}</del></i></h2>
                            <h2 class="price "><i class="fa fa-inr" aria-hidden="true">{{ $product->price }}</i></h2>

                            <p>{{ $product->description }}</p>
                            <a href="" onclick="addToCart({{$product->id}})" class="btn btn-dark"><i class="fas fa-shopping-cart"></i> &nbsp;ADD TO
                                CART</a>
                        </div>
                    </div>

                    <div class="col-md-12 mt-5">
                        <div class="bg-light">
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
                                        {{ $product->description }}
                                    </p>
                                </div>
                                <div class="tab-pane fade" id="shipping" role="tabpanel"
                                    aria-labelledby="shipping-tab">
                                    <p></p>
                                </div>
                                <div class="tab-pane fade" id="reviews" role="tabpanel"
                                    aria-labelledby="reviews-tab">
                                    {{-- <img style="width: 100px; height: 70px; object-fit: contain;!important" src="{{ asset('admin_assets/images/' . $product->brand->image) }}"> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

    {{-- <section class="pt-5 section-8">
        <div class="container">
            <div class="section-title">
                <h2>Related Products</h2>
            </div>
            <div class="col-md-12">
                <div id="related-products" class="carousel">
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="" class="product-img"><img class="card-img-top"
                                    src="images/product-1.jpg" alt=""></a>
                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                            <div class="product-action">
                                <a class="btn btn-dark" href="#">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="">Dummy Product Title</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>$100</strong></span>
                                <span class="h6 text-underline"><del>$120</del></span>
                            </div>
                        </div>
                    </div>
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="" class="product-img"><img class="card-img-top"
                                    src="images/product-1.jpg" alt=""></a>
                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                            <div class="product-action">
                                <a class="btn btn-dark" href="#">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="">Dummy Product Title</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>$100</strong></span>
                                <span class="h6 text-underline"><del>$120</del></span>
                            </div>
                        </div>
                    </div>
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="" class="product-img"><img class="card-img-top"
                                    src="images/product-1.jpg" alt=""></a>
                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                            <div class="product-action">
                                <a class="btn btn-dark" href="#">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="">Dummy Product Title</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>$100</strong></span>
                                <span class="h6 text-underline"><del>$120</del></span>
                            </div>
                        </div>
                    </div>
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="" class="product-img"><img class="card-img-top"
                                    src="images/product-1.jpg" alt=""></a>
                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                            <div class="product-action">
                                <a class="btn btn-dark" href="#">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="">Dummy Product Title</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>$100</strong></span>
                                <span class="h6 text-underline"><del>$120</del></span>
                            </div>
                        </div>
                    </div>
                    <div class="card product-card">
                        <div class="product-image position-relative">
                            <a href="" class="product-img"><img class="card-img-top"
                                    src="images/product-1.jpg" alt=""></a>
                            <a class="whishlist" href="222"><i class="far fa-heart"></i></a>

                            <div class="product-action">
                                <a class="btn btn-dark" href="#">
                                    <i class="fa fa-shopping-cart"></i> Add To Cart
                                </a>
                            </div>
                        </div>
                        <div class="card-body text-center mt-3">
                            <a class="h6 link" href="">Dummy Product Title</a>
                            <div class="price mt-2">
                                <span class="h5"><strong>$100</strong></span>
                                <span class="h6 text-underline"><del>$120</del></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
</main>

{{-- <script type="text/javascript">
    function addToCart(id){
        // alert(id);

        $.ajax({
            url:'/addcart',
            type:'',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            contentType: false,
            processData: false,
            data:{id:id},
            success:function(response){

            }
        })
    }
</script> --}}



@include('user.includes.footer')
