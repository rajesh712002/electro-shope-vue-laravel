@include('user.includes.header')
{{-- <tbody>
                                        {{- @foreach ($carts as $cart) -}}
                                        @foreach ($product as $item)
                                            <tr>
                                                {{- @dd($product) -}}
                                                <td>
                                                    <a href="{{ route('viewproduct', $item->slug) }}">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <img src="{{ asset('admin_assets/images/' . $item->image) }}"
                                                                width="120" height="120">
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="text-dark" href="{{ route('viewproduct', $item->slug) }}">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            {{- <h2>{{$product->prod_name}}</h2> -}}
                                                            {{ $item->prod_name }}
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>{{ $item->price }}</td>
                                                <td>
                                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                                        <div class="input-group-btn">
                                                            <form method="POST"
                                                                action="{{ route('qty.decrease', $item->cid) }}"
                                                                id="DecreaseCartForm">
                                                                @csrf
                                                                @method('PUT')
                                                                <button type="submit"
                                                                    class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </form>

                                                        </div>
                                                        <input type="text" name="quantity"
                                                            class="form-control form-control-sm  border-0 text-center"
                                                            value="{{ $item->cqty }}" min="1"
                                                            max="{{ $item->qty }}" readonly>

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

                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $item->price * $item->cqty }}
                                                </td>
                                                <td>

                                                    <form id="delete-product-form-{{ $item->cid }}"
                                                        class="delete_cat" method="post"
                                                        action="{{ route('qty.remove_item', $item->cid) }}">
                                                        @csrf
                                                        @method('delete')
                                                    </form>

                                                    <button onclick="deleteProduct({{ $item->cid }});"
                                                        type="submit" class="btn btn-sm btn-danger"><i
                                                            class="fa fa-times"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach

                                         @endforeach 

                                    </tbody> --}}
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>


<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('userindex') }}">Home</a></li>
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
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif
                    @if (Auth::check())

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
                                        @foreach ($product as $item)
                                            <tr id="cart-item-{{ $item->cid }}">
                                                <td><a href="{{ route('viewproduct', $item->slug) }}">
                                                    <img  width="120" height="120"
                                                        class="cardimgtop"
                                                        @if (!empty($item->images))
                                                         src="{{ asset('admin_assets/images/' . $item->images) }}" alt="">
                                                        @else
                                                        src="{{ asset('admin_assets/images/' . $item->image) }}" alt="">
                                                         @endif
                                                        </a>
                                                   
                                                </td>
                                                <td>{{ $item->prod_name }}</td>
                                                <td>{{ $item->price }}</td>
                                                <td>
                                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                                        <div class="input-group-btn">
                                                            <button type="button"
                                                                class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1"
                                                                onclick="updateQuantity({{ $item->cid }}, 'decrease')">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm border-0 text-center"
                                                            id="cart-quantity-{{ $item->cid }}"
                                                            value="{{ $item->cqty }}" readonly>
                                                        <div class="input-group-btn">
                                                            <button type="button"
                                                                class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1"
                                                                onclick="updateQuantity({{ $item->cid }}, 'increase')">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td id="cart-total-{{ $item->cid }}">
                                                    {{ $item->price * $item->cqty }}
                                                </td>
                                                <td>
                                                    <button onclick="removeItem({{ $item->cid }});"
                                                        class="btn btn-sm btn-danger">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
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
                    @else
                        @php
                            // Get guest cart data from session
                            $guestCart = session()->get('cart', []);
                        @endphp

                        @if (count($guestCart) > 0)
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
                                        @foreach ($guestCart as $key => $item)
                                            <tr>
                                                <td>
                                                    <a href="{{-- route('viewproduct', $item['slug']) --}}">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            <img src="{{ asset('admin_assets/images/' . $item['image']) }}"
                                                                width="120" height="120">
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>
                                                    <a class="text-dark" href="{{-- route('viewproduct', $item['slug']) --}}">
                                                        <div class="d-flex align-items-center justify-content-center">
                                                            {{ $item['name'] }}
                                                        </div>
                                                    </a>
                                                </td>
                                                <td>{{ $item['price'] }}</td>
                                                <td>
                                                    <div class="input-group quantity mx-auto" style="width: 100px;">
                                                        <div class="input-group-btn">
                                                            <button type="button"
                                                                onclick="decreaseGuestQty('{{ $key }}')"
                                                                class="btn btn-sm btn-dark btn-minus p-2 pt-1 pb-1">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text" name="quantity"
                                                            class="form-control form-control-sm border-0 text-center"
                                                            value="{{ $item['qty'] }}" min="1"
                                                            max="{{ $item['max_qty'] }}" readonly>
                                                        <div class="input-group-btn">
                                                            <button type="button"
                                                                onclick="increaseGuestQty('{{ $key }}')"
                                                                class="btn btn-sm btn-dark btn-plus p-2 pt-1 pb-1">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $item['price'] * $item['qty'] }}</td>
                                                <td>
                                                    <button onclick="removeGuestItem('{{ $key }}')"
                                                        type="button" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
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
                    @endif

                </div>
                @if (Auth::check())

                    @if (cartCount() > 0)
                        
                        <!-- Coupon Codes Modal -->
                        <div class="modal fade" id="couponModal" tabindex="-1" aria-labelledby="couponModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="couponModalLabel">Available Coupons</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="list-group" id="couponList">
                                            <!-- Coupon codes will be populated here -->
                                        </ul>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="card cart-summery">

                                <div class="sub-title">
                                    <h2 class="bg-white">Cart Summary</h2>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between pb-2">
                                        <div>Subtotal</div>
                                        <div><i class="fa fa-inr" aria-hidden="true"></i> <span
                                                id="cart-subtotal">{{ $totalSum }}</span></div>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <div>Discount</div>
                                        <div id="cart-discount">{{ $discount }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <div>Shipping</div>
                                        <div>Free</div>
                                    </div>
                                    <br>
                                    <div class="input-group apply-coupan mt-4">

                                        <input type="text" placeholder="Coupon Code" class="form-control"
                                            name="discount_code" id="discount_code" value="{{ $couponCode }}">
                                        <button class="btn btn-dark" type="button" id="apply_discount">Apply
                                            Coupon</button>

                                    </div>
                                    <button class="btn btn-danger btn-sm" type="button" id="remove_coupon"
                                        style="display: {{ $couponCode ? 'inline-block' : 'none' }};">Remove
                                        Coupon</button>
                                    <button type="button" class="btn btn-info mt-3" data-bs-toggle="modal"
                                        data-bs-target="#couponModal">
                                        View Available Coupons
                                    </button>

                                    <br><br>

                                    <div class="d-flex justify-content-between summery-end">
                                        <div>Total</div>
                                        <div><i class="fa fa-inr" aria-hidden="true"></i> <span
                                                id="cart-total">{{ $newTotal }}</span></div>
                                    </div>
                                    <div class="pt-5">
                                        <a id="checkout" href="{{ route('user.checkout') }}"
                                            class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    @php
                        // Get the cart data from the session
                        $cart = session()->get('cart', []);
                        $guestTotalSum = 0;

                        // Calculate the total sum for guest cart
                        foreach ($cart as $item) {
                            $guestTotalSum += $item['qty'] * $item['price'];
                        }
                    @endphp

                    @if (count($cart) > 0)
                        <div class="col-md-4">
                            <div class="card cart-summery">
                                <div class="sub-title">
                                    <h2 class="bg-white">Cart Summary</h2>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-between pb-2">
                                        <div>Subtotal</div>
                                        <div><i class="fa fa-inr" aria-hidden="true"></i> {{ $guestTotalSum }}</div>
                                    </div>
                                    <div class="d-flex justify-content-between pb-2">
                                        <div>Shipping</div>
                                        <div>Free</div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between summery-end">
                                    <div>Total</div>
                                    <div><i class="fa fa-inr" aria-hidden="true"></i> {{ $guestTotalSum }}</div>
                                </div>
                                <div class="pt-5">
                                    <a href="{{ route('user.checkout') }}"
                                        class="btn-dark btn btn-block w-100">Proceed to Checkout</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
        </div>
    </section>
</main>



{{-- GUEST CART FUNCTIONALITY --}}
<script>
    function decreaseGuestQty(key) {
        // Decrease guest quantity logic
        $.post("{{ route('guest.cart.qty.decrease') }}", {
            _token: '{{ csrf_token() }}',
            key: key
        }, function(data) {
            location.reload();
        });
    }

    function increaseGuestQty(key) {
        // Increase guest quantity logic
        $.post("{{ route('guest.cart.qty.increase') }}", {
            _token: '{{ csrf_token() }}',
            key: key
        }, function(data) {
            location.reload();
        });
    }

    function removeGuestItem(key) {
        // Remove guest item logic
        $.post("{{ route('guest.cart.remove') }}", {
            _token: '{{ csrf_token() }}',
            key: key
        }, function(data) {
            location.reload();
        });
    }

    document.getElementById("checkout").addEventListener("submit", function() {
        document.querySelector(".overlay").style.display = "flex";
    });
</script>



<script src="{{ asset('user_assets/js/ajx.js') }}"></script>

@include('user.includes.footer')
