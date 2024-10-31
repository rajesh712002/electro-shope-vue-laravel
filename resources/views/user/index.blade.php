<!DOCTYPE html>

@include('user.includes.header')
<style>
    .carousel-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

</style>
<main>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>

    <section class="section-1">
        {{-- <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
            data-bs-interval="false">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <!-- <img src="images/carousel-1.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <source media="(max-width: 799px)" srcset="{{ asset('admin_assets/images/phones.png') }}" />
                        <a href="{{ route('usershop') }}">
                            <source media="(min-width: 800px)" srcset="{{ asset('admin_assets/images/phones.png') }}" />
                        </a>
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
                        <a href="{{ route('usershop') }}">
                            <source media="(max-width: 799px)"
                                srcset="{{ asset('admin_assets/images/leptopss.png') }}" />
                            <source media="(min-width: 800px)"
                                srcset="{{ asset('admin_assets/images/leptopss.png') }}" />
                            <img src="{{ asset('admin_assets/images/leptopss.png') }}" alt="" />
                        </a>
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">New Limited Adition Laptops</h1>
                            <p class="mx-md-5 px-5">Introducing the Limited Edition Laptops: Sleek design, powerful
                                performance, cutting-edge graphics,
                                ultra-lightweight, long-lasting battery, advanced cooling, vibrant display, and premium
                                build quality.</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('usershop') }}">Shop Now</a>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <!-- <img src="images/carousel-3.jpg" class="d-block w-100" alt=""> -->

                    <picture>
                        <a href="{{ route('usershop') }}">
                            <source media="(max-width: 799px)"
                                srcset="{{ asset('admin_assets/images/watchs.png') }}" />
                            <source media="(min-width: 800px)"
                                srcset="{{ asset('admin_assets/images/watchs.png') }}" />
                            <img src="{{ asset('admin_assets/images/watchs.png') }}" alt="" />
                        </a>
                    </picture>

                    <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                        <div class="p-3">
                            <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off on Branded Watches</h1>
                            <p class="mx-md-5 px-5">Shop online now and get up to 70% off on branded watches! Don't miss
                                out on this amazing discount.
                                Grab your favorite timepieces at unbeatable prices. Limited time offer. Shop today!</p>
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
        </div> --}}
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel"
            data-bs-interval="false">
            <div class="carousel-inner"></div>
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
                @if (getcategory()->isNotEmpty())


                    @foreach (getcategory() as $item)
                        @if ($item->status == 1)
                            <div class="col-lg-3">
                                <div class="cat-card">
                                    <a href="{{ route('usershop') }}">
                                        <div class="left">

                                            <img style="width: 100px; height: 100px; object-fit:contain ;"
                                                class="imgfluid"
                                                src="{{ asset('admin_assets/images/' . $item->image) }}" alt="">

                                        </div>
                                    </a>
                                    <div class="right">
                                        <a href="{{ route('usershop') }}">
                                            <div class="cat-data">
                                                <h2><b>{{ $item->name }}</b></h2>
                                                <p><b>{{ $item->product_count }} Products</b></p>
                                                {{-- @dump($item->product_count) --}}
                                            </div>
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @endif
                    @endforeach
                @endif

            </div>
        </div>
    </section>

    <section class="section-4 pt-5">
        <div class="container">

        </div>
    </section>

    <section class="section-4 pt-5">
        <div class="container">
            <div class="section-title">
                <h2>Latest Produsts</h2>
            </div>
            <div class="row pb-3">
                {{-- @dd( session()->get('cart', [])); --}}
                @foreach (getproduct() as $prod)
                    <div class="col-md-3">
                        <div class="card product-card">
                            <div class="product-image position-relative">
                                <a href="{{ route('viewproduct', $prod->slug) }}">
                                    {{-- <img style="width: 200px; height: 200px; object-fit: contain;" class="cardimgtop"
                                        src="{{ asset('admin_assets/images/' . $prod->image) }}" alt=""> --}}

                                    @php
                                        $image = $prod->productImages->first();
                                    @endphp
                                    <img style="width: 200px; height: 200px; object-fit: contain;" class="cardimgtop"
                                        @if (!empty($image->images)) src="{{ asset('admin_assets/images/' . $image->images) }}"
                                            alt="">
                                        @else
                                            src="{{ asset('admin_assets/images/' . $prod->image) }}"
                                            alt=""> @endif
                                        {{-- <a class="whishlist" href="222"><i class="far fa-heart"></i></a> --}} <form method="POST"
                                        action="{{ route('user.addToWishlist') }}">
                                    @csrf
                                    <input type="hidden" name="prod_id" value="{{ $prod->id }}" />
                                    <input type="hidden" name="user_id" value="{{ chechUserLogin() }}" />

                                    <button type="submit" class="whishlist "><i class="far fa-heart"></i></button>
                                    </form>
                                </a>
                                <div class="product-action">

                                    <form action="{{ route('user.addToCart') }}" method="POST">
                                        {{-- @dd($product) --}}
                                        @csrf
                                        <input type="hidden" name="prod_id" value="{{ $prod->id }}" />
                                        <input type="hidden" name="user_id" value="{{ chechUserLogin() }}" />
                                        <input type="hidden" name="qty" value="1" />
                                        <input type="hidden" name="price" value="{{ $prod->price }}" />
                                        <input type="hidden" name="name" value="{{ $prod->prod_name }}" />
                                        <input type="hidden" name="image" value="{{ $prod->image }}" />
                                        <input type="hidden" name="max_qty" value="{{ $prod->qty }}" />

                                        <button type="submit" class="btn btn-dark"><i
                                                class="fas fa-shopping-cart"></i> Add To Cart</button>
                                    </form>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="card-body text-center mt-3">
                                <a class="h6 link" style="text-decoration: none"
                                    href="{{ route('viewproduct', $prod->slug) }}">{{ $prod->prod_name }}</a>
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
<script>
    $(document).ready(function(e) {
        console.log('hello')
        // e.preventDefault();
        $.ajax({
            url: '/user/bannerCursor',
            method: 'GET',
            success: function(data) {
                console.log('hello')
                let carouselInner = $('#carouselExampleIndicators .carousel-inner');
                carouselInner.empty();

                data.forEach((item, index) => {
                    let activeClass = index === 0 ? 'active' : '';
                    carouselInner.append(`
                    <div class="carousel-item ${activeClass}">
                        <picture>
                            <source media="(max-width: 100%)" srcset="${item.image_path}">
                            <source media="(min-width: 100%)" srcset="${item.image_path}">
                            <img src="${item.image_path}" alt="${item.title}" />
                        </picture>
                        <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                            <div class="p-3">
                                <h1 class="display-4 text-white mb-3">${item.title}</h1>
                                <p class="mx-md-5 px-5">${item.description}</p>
                                <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{ route('usershop') }}">Shop Now</a>
                            </div>
                        </div>
                    </div>
                `);
                });
            },
            error: function(error) {
                console.log("Error fetching carousel data", error);
            }
        });
    });
</script>
{{-- <script src="{{ asset('admin_assets/js/ajx.js') }}"></script> --}}

@include('user.includes.footer')
