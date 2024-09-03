@include('user.includes.header')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('userindex') }}">Home</a></li>
                    <li class="breadcrumb-item active">Shop</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-6 pt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3 sidebar">
                    <div class="sub-title">
                        <h2>Categories</h3>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="accordion accordion-flush" id="accordionExample">
                                <div class="accordion-item">
                                    @if ($categorys->isNotEmpty())
                                        @foreach ($categorys as $key => $category)
                                            @if ($category->status == 1)
                                                <a href="{{ route('usershop', $category->slug) }}">
                                                    <h2 class="accordion-header" id="headingOne">
                                                        @if ($category->subcategory->isNotEmpty())
                                                            <button
                                                                class="accordion-button collapsed {{ $categorySelected == $category->id ? 'text-danger' : '' }}"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseOne-{{ $key }}"
                                                                aria-expanded="false" aria-controls="collapseOne">
                                                                {{ $category->name }}
                                                            </button>
                                                    </h2>
                                                </a>
                                            @else
                                                <a href="{{ route('usershop', $category->slug) }}"
                                                    class="nav-item- nav-link {{ $categorySelected == $category->id ? 'text-danger' : '' }}">{{ $category->name }}</a>
                                            @endif
                                            @if ($category->subcategory->isNotEmpty())
                                                <div id="collapseOne-{{ $key }}"
                                                    class="accordion-collapse collapse {{ $categorySelected == $category->id ? 'show' : '' }}"
                                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample"
                                                    style="">
                                                    <div class="accordion-body">
                                                        <div class="navbar-nav">
                                                            @foreach ($category->subcategory as $subcategory)
                                                                <a href="{{ route('usershop', ['categoryslug' => $category->slug, 'subcategoryslug' => $subcategory->slug]) }}"
                                                                    {{-- <a href="/user/shop/{{ $category->slug}}/{{$subcategory->slug}}" --}}
                                                                    class="nav-item nav-link {{ $subcategorySelected == $subcategory->id ? 'text-danger' : '' }}">{{ $subcategory->subcate_name }}</a>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-9">
                    <div class="row pb-3">
                        <div class="col-12 pb-1">
                            <div class="d-flex align-items-center justify-content-end mb-4">
                                <div class="ml-2">

                                    <select id="sort" name="sort" class="form-control"
                                        onchange="sortProducts()">
                                        <option>---Sort---</option>
                                        <option value="latest">Latest</option>
                                        <option value="price_desc">Price High</option>
                                        <option value="price_asc">Price Low</option>
                                    </select>
                                </div>
                            </div>
                        </div>


                        @foreach ($products as $prod)
                            <div class="col-md-4">
                                <div class="card product-card">
                                    <div class="product-image position-relative">
                                        <a href="{{ route('viewproduct', $prod->slug) }}">
                                            <img style="width: 200px; height: 200px; object-fit: contain;"
                                                class="cardimgtop"
                                                src="{{ asset('admin_assets/images/' . $prod->image) }}"
                                                alt="">
                                        </a>
                                        <form method="POST" action="{{ route('user.addToWishlist') }}">
                                            @csrf
                                            <input type="hidden" name="prod_id" value="{{ $prod->id }}" />
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />

                                            <button type="submit" class="whishlist "><i
                                                    class="far fa-heart"></i></button>
                                        </form>
                                        <div class="product-action">


                                            <form action="{{ route('user.addToCart') }}" method="POST">
                                                {{-- @dd($product) --}}
                                                @csrf
                                                <input type="hidden" name="prod_id" value="{{ $prod->id }}" />
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                <input type="hidden" name="qty" value="1" />
                                                <button type="submit" class="btn btn-dark"><i
                                                        class="fas fa-shopping-cart"></i> Add To Cart</button>
                                            </form>
                                            {{-- @endif --}}
                                        </div>
                                    </div>

                                    <div class="card-body text-center mt-3">
                                        <a class="h6 link"
                                            href="{{ route('viewproduct', $prod->slug) }}">{{ $prod->prod_name }}</a>

                                        <div class="price mt-2">
                                            <span class="h5"><strong><i class="fa fa-inr" aria-hidden="true">
                                                    </i>
                                                    {{ $prod->price }}</strong></span>
                                            <span
                                                class="h6 text-underline"><del>{{ $prod->compare_price }}</del></span>
                                            <div class="text-secondary"> InStock:- {{ $prod->qty }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-md-12 pt-5">
                            <nav aria-label="Page navigation example">
                                {{ $products->onEachSide(1)->links() }}
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>


<script>
    function sortProducts() {
        var sortValue = document.getElementById('sort').value;
        var url = new URL(window.location.href);
        url.searchParams.set('sort', sortValue);
        window.location.href = url.href;
    }
</script>

@include('user.includes.footer')
