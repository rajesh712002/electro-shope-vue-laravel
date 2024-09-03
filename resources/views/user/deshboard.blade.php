@include('user.includes.header')

<main>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <section class="section-1">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
            data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="images/carousel-1-m.jpg" />
                        <source media="(min-width: 800px)" srcset="{{ asset('admin_assets/images/phones.png') }}" />
                        {{-- <img src="{{ asset('/user_assets/images/carousel-1.jpg') }}" alt="" /> --}}
                        <img src="{{ asset('admin_assets/images/phones.png') }}" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Latest Phones</h1>
                            <p class="mx-md-5 px-5">Get the best deals on the latest smartphones! Discover top features,
                                cutting-edge tech, and exclusive offers.
                                Limited time discounts on leading brands. Upgrade now and save!</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('usershop') }}">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">

                    <picture>
                        <source media="(max-width: 799px)"
                            srcset="{{ asset('/user_assets/images/carousel-2-m.jpg') }}" />
                        <source media="(min-width: 800px)" srcset="{{ asset('admin_assets/images/leptopss.png') }}" />
                        <img src="" alt="{{ asset('/user_assets/images/carousel-2-m.jpg') }}" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">New Limited Adition Laptops</h1>
                            <p class="mx-md-5 px-5">Shop online now and get up to 70% off on branded watches! Don't miss
                                out on this amazing discount.
                                Grab your favorite timepieces at unbeatable prices. Limited time offer. Shop today!.</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('usershop') }}">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)"
                            srcset="{{ asset('/user_assets/images/carousel-3-m.jpg') }}" />
                        <source media="(min-width: 800px)" srcset="{{ asset('admin_assets/images/watchs.png') }}" />
                        <img src="{{ asset('/user_assets/images/carousel-3-m.jpg') }}" alt="" />
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off on Branded Watches</h1>
                            <p class="mx-md-5 px-5">Lorem rebum magna amet lorem magna erat diam stet. Sadips duo stet
                                amet amet ndiam elitr ipsum diam</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('usershop') }}">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <section class="section-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-check text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Quality Product</h5>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-shipping-fast text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">Free Shipping</h2>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-exchange-alt text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">14-Day Return</h2>
                    </div>
                </div>
                <div class="col-lg-3 ">
                    <div class="box shadow-lg">
                        <div class="fa icon fa-phone-volume text-primary m-0 mr-3"></div>
                        <h2 class="font-weight-semi-bold m-0">24/7 Support</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="section-3">
        <div class="container">
            <div class="section-title">
                <h2>Categories</h2>
            </div>

            <div class="row pb-3">
                @foreach ($category as $item)
                    @if ($item->status == 1)
                        <div class="col-lg-3">
                            <div class="cat-card">
                                <div class="left">
                                    <a href="{{ route('usershop') }}">
                                        <img style="width: 100px; height: 100px; object-fit:contain ;" class="imgfluid"
                                            src="{{ asset('admin_assets/images/' . $item->image) }}" alt="">
                                    </a>
                                </div>
                                <div class="right">
                                    <a href="{{ route('usershop') }}" style=" text-decoration: none!important">
                                        <div class="cat-data">
                                            <h2><b>{{ $item->name }}</b></h2>
                                            <p><b>{{ $item->product_count }} Products</b></p>
                                            {{-- @dd($item->product_count) --}}
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach

            </div>
        </div>
    </section>



    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Latest Produsts</h2>
            </div>
            <div class="row pb-3">

                @foreach ($product as $prod)
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="" class="product-img">
                                    {{-- <img class="card-img-top"
                                    src="images/product-1.jpg" alt=""> --}}
                                    <img style="width: 200px; height: 200px; object-fit: contain;" class="cardimgtop"
                                        src="{{ asset('admin_assets/images/' . $prod->image) }}" alt="">
                                </a>

                                {{-- <a class="whishlist" href="222"><i class="far fa-heart"></i></a> --}}
                                @if (Auth::check())
                                    <form method="POST" action="{{ route('user.addToWishlist') }}">
                                        @csrf
                                        <input type="hidden" name="prod_id" value="{{ $prod->id }}" />
                                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />

                                    </form>
                                @endif
                                <a class="whishlist" href="{{ route('user.wishlist') }}"><i
                                        class="far fa-heart"></i></a>
                                <div class="product-action">

                                    @if (Auth::check())
                                        <form action="{{ route('user.addToCart') }}" method="POST">
                                            {{-- @dd($product) --}}
                                            @csrf
                                            <input type="hidden" name="prod_id" value="{{ $prod->id }}" />
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                            <input type="hidden" name="qty" value="1" />
                                        </form>
                                    @endif
                                    <a class="btn btn-dark" href="{{ route('user.index') }}"><i
                                            class="fas fa-shopping-cart"></i> Add To Cart</a>
                                </div>
                            </div>
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" href="{{ route('usershop') }}">{{ $prod->prod_name }}</a>
                                <div class="price mt-2">
                                    <span class="h5"><strong><i class="fa fa-inr" aria-hidden="true"> </i>
                                            {{ $prod->price }}</strong></span>
                                    <span class="h6 text-underline"><del>{{ $prod->compare_price }}</del></span>
                                </div>
                                <div class="text-secondary"> InStock:- {{ $prod->qty }}</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@include('user.includes.footer')
