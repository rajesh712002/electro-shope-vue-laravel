{{-- 
<h1 class="display-4 text-white mb-3">Latest Phones</h1>
<p class="mx-md-5 px-5">Get the best deals on the latest smartphones! Discover top features, cutting-edge tech, and exclusive offers. 
    Limited time discounts on leading brands. Upgrade now and save!</p>
<a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('usershop')}}">Shop Now</a>

<h1 class="display-4 text-white mb-3">New Limited Adition Laptops</h1>
                            <p class="mx-md-5 px-5">Introducing the Limited Edition Laptops: Sleek design, powerful performance, cutting-edge graphics, 
                                ultra-lightweight, long-lasting battery, advanced cooling, vibrant display, and premium build quality.</p>
                            <a class="btn btn-outline-light py-2 px-4 mt-3" href="{{route('usershop')}}">Shop Now</a>
                        </div>

                        <h1 class="display-4 text-white mb-3">Shop Online at Flat 70% off on Branded Watches</h1>
                            <p class="mx-md-5 px-5">Shop online now and get up to 70% off on branded watches! Don't miss out on this amazing discount. 
                                Grab your favorite timepieces at unbeatable prices. Limited time offer. Shop today!</p> --}}

@include('user.includes.header')
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="#">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('usershop') }}">Shop</a></li>
                    <li class="breadcrumb-item">Cart</li>
                </ol>
            </div>
        </div>
    </section>

    <section class=" section-9 pt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    {{-- @dd($carts) --}}
                    @if ($product->count() > 0)

                        <div class="table-responsive">
                            <table class="table" id="cart">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Item</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach ($carts as $cart) --}}
                                    @foreach ($product as $item)
                                        <tr>
                                            {{-- @dd($product) --}}
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    <img src="{{ asset('admin_assets/images/' . $item->image) }}"
                                                        width="120" height="120">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center justify-content-center">
                                                    {{-- <h2>{{$product->prod_name}}</h2> --}}
                                                    {{ $item->prod_name }}
                                                </div>
                                            </td>
                                            <td>{{ $item->price }}</td>
                                            <td>
                                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                                    <div class="input-group-btn">
                                                        <form method="POST"
                                                            action="{{ route('qty.decrease',$item->cid) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </form>
                                                        {{-- <button type="submit"
                                                            class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1">
                                                            <i class="fa fa-minus"></i>
                                                        </button> --}}
                                                    </div>
                                                    <input type="text" name="quantity"
                                                        class="form-control form-control-sm  border-0 text-center"
                                                        value="{{ $item->cqty }}" min="1"
                                                        max="{{ $item->qty }}">

                                                    <div class="input-group-btn">
                                                        <form method="POST"
                                                            action="{{ route('qty.increase', $item->cid) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="submit"
                                                                class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </form>
                                                        {{-- <button type="submit"
                                                            class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1">
                                                            <i class="fa fa-plus"></i>
                                                        </button> --}}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                {{ $item->price * $item->cqty }}
                                            </td>
                                            <td>
                                                {{-- <form method="POST" action="{{route('qty.remove_item', ['rowId' => $item->rowId])}}">
                                                    @csrf
                                                            @method('delete')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i
                                                            class="fa fa-times"></i></button>
                                                </form> --}}


                                                <form id="delete-product-form-{{ $item->cid }}" class="delete_cat"
                                                    method="post" action="{{ route('qty.remove_item', $item->cid) }}">
                                                    @csrf
                                                    @method('delete')
                                                </form>

                                                <button onclick="deleteProduct({{ $item->cid }});" type="submit"
                                                    class="btn btn-sm btn-danger"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach

                                    {{-- @endforeach --}}

                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-12 text-center pt-5 bp-5">
                                <p>No items found in your cart </p>
                                <a href="{{ route('usershop') }}" class="btn btn-info">Shop Now</a>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="col-md-4">
                    <div class="card cart-summery">
                        <div class="sub-title">
                            <h2 class="bg-white">Cart Summery</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between pb-2">
                                <div>Subtotal</div>
                                <div><i class="fa fa-inr" aria-hidden="true">
                                    </i> {{$totalSum}}</div>
                            </div>
                            <div class="d-flex justify-content-between pb-2">
                                <div>Shipping</div>
                                {{-- <div><i class="fa fa-inr" aria-hidden="true"> --}}
                                </i> Free
                            </div>
                        </div>
                        <div class="d-flex justify-content-between summery-end">
                            <div>Total</div>
                            <div><i class="fa fa-inr" aria-hidden="true">
                                </i> {{$totalSum}}</div>
                        </div>
                        <div class="pt-5">
                            <a href="" class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                        </div>
                    </div>
                </div>
                {{-- <div class="input-group apply-coupan mt-4">
                        <input type="text" placeholder="Coupon Code" class="form-control">
                        <button class="btn btn-dark" type="button" id="button-addon2">Apply Coupon</button>
                    </div> --}}
            </div>
        </div>
        </div>
    </section>
</main>
<script>
    function deleteProduct(id) {
        if (confirm("Do you really want to delete this record ?")) {
            document.getElementById("delete-product-form-" + id).submit();
        }
    }
</script>
@include('user.includes.footer')
