@include('user.includes.header')<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('usershop') }}">Shop</a></li>
                    <li class="breadcrumb-item"><a class="white-text">My Account</a></li>
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
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                    <div class="card">
                        <div class="card-header">
                            <h2 class="h5 mb-0 pt-2 pb-2">My Wishlist</h2>
                        </div>
                        {{-- @dd($product) --}}
                        @if ($product->count() > 0)
                            @forelse ($product as $item)
                                {{-- @dd($item) --}}
                                <div class="card-body p-4">
                                    <div
                                        class="d-sm-flex justify-content-between mt-lg-4 mb-4 pb-3 pb-sm-2 border-bottom">
                                        <div class="d-block d-sm-flex align-items-start text-center text-sm-start"><a
                                                href="{{ route('viewproduct', $item->slug) }}"
                                                class="d-block flex-shrink-0 mx-auto me-sm-4" style="width: 10rem;">
                                                <img src="{{ asset('admin_assets/images/' . $item->image) }}"
                                                    width="120" height="120">
                                                <div class="pt-2">
                                                    <h3 class="product-title fs-base mb-2"><a class="text-dark"
                                                            href="{{ route('viewproduct', $item->slug) }}">{{ $item->prod_name }}</a>
                                                    </h3>
                                                    <div class="fs-lg text-accent pt-2"> <i class="fa fa-inr"
                                                            aria-hidden="true"> {{ $item->price }}</i>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="pt-2 ps-sm-3 mx-auto mx-sm-0 text-center">
                                            <form method="POST" action="{{ route('user.moveToCart', $item->wid) }}">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="prod_id" value="{{ $item->id }}" />
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                <input type="hidden" name="qty" value="1" />
                                                <button type="submit" class="btn btn-outline-success btn-sm"
                                                    type="button">Add To Cart</button>
                                            </form>

                                            <form id="delete-product-form-{{ $item->wid }}" class="delete_cat"
                                                method="post"
                                                action="{{ route('user.remove_wishlist', $item->wid) }}">
                                                @csrf
                                                @method('delete')
                                            </form>
                                            <button type="submit" onclick="deleteProduct({{ $item->wid }});"
                                                class="btn btn-outline-danger btn-sm" type="button"><i
                                                    class="fas fa-trash-alt me-2"></i>Remove</button>
                                        </div>
                                    </div>


                                </div>
                            @endforeach
                        @else
                            <div class="row">
                                <div class="col-md-12 text-center pt-5 bp-5">
                                    <p>No items found in your wishlist </p>
                                    <a href="{{ route('usershop') }}" class="btn btn-info">Shop Now</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    function deleteProduct(id) {
        // if (confirm("Do you really want to remove this Item ?")) {
            document.getElementById("delete-product-form-" + id).submit();
        // }
    }
</script>
@include('user.includes.footer')
