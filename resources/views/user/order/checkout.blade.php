@include('user.includes.header')
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<main>
    <section class="section-5 pt-3 pb-3 mb-3 bg-white">
        <div class="container">
            <div class="light-font">
                <ol class="breadcrumb primary-color mb-0">
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('userindex') }}">Home</a></li>
                    <li class="breadcrumb-item"><a class="white-text" href="{{ route('usershop') }}">Shop</a></li>
                    <li class="breadcrumb-item">Checkout</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="section-9 pt-4">
        <div class="container">
            @if (session('status'))
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            @endif
            <form id="CheckoutForm" method="post" action="{{ route('user.storecheckout') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="sub-title">
                            <h2>Shipping Address</h2>
                        </div>
                        <div class="card shadow-lg border-0">
                            <div class="card-body checkout-form">
                                <div class="row">

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="first_name" id="first_name" class="form-control"
                                                placeholder="First Name"
                                                value="{{ !empty($CustomerAddress) ? $CustomerAddress->first_name : '' }}">
                                            <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="last_name" id="last_name" class="form-control"
                                                placeholder="Last Name"
                                                value="{{ !empty($CustomerAddress) ? $CustomerAddress->last_name : '' }}">
                                            <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="email" id="email" class="form-control"
                                                placeholder="Email"
                                                value="{{ !empty($CustomerAddress) ? $CustomerAddress->email : '' }}">
                                            <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <select name="country" id="country" class="form-control"
                                                value="{{ !empty($CustomerAddress) ? $CustomerAddress->country : '' }}">
                                                {{-- <option value="">Select a Country</option> --}}
                                                <option value="india">India</option>
                                                {{-- <option value="2">UK</option> --}}
                                            </select>
                                            <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="address" id="address" cols="30" rows="3" placeholder="Address" class="form-control"
                                                value="">{{ !empty($CustomerAddress) ? $CustomerAddress->address : '' }}</textarea>
                                            <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="appartment" id="appartment" class="form-control"
                                                placeholder="Apartment, suite, unit, etc. (optional)"
                                                value="{{ !empty($CustomerAddress) ? $CustomerAddress->apartment : '' }}">
                                            <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="city" id="city" class="form-control"
                                                placeholder="City"
                                                value="{{ !empty($CustomerAddress) ? $CustomerAddress->city : '' }}">
                                            <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="state" id="state" class="form-control"
                                                placeholder="State"
                                                value="{{ !empty($CustomerAddress) ? $CustomerAddress->state : '' }}">
                                            <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <input type="text" name="zip" id="zip" class="form-control"
                                                placeholder="Zip"
                                                value="{{ !empty($CustomerAddress) ? $CustomerAddress->pincode : '' }}">
                                            <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <input type="text" name="mobile" id="mobile" class="form-control"
                                                placeholder="Mobile No."
                                                value="{{ !empty($CustomerAddress) ? $CustomerAddress->mobile : '' }}">
                                            <p></p>
                                            <h6 style="color: rgb(255, 0,0)" class="error"></h6>

                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <textarea name="order_notes" id="order_notes" cols="30" rows="2" placeholder="Order Notes (optional)"
                                                class="form-control" value="">{{ !empty($CustomerAddress) ? $CustomerAddress->order_notes : '' }}</textarea>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="sub-title">
                            <h2>Order Summery</h3>
                        </div>
                        <div class="card cart-summery">
                            <div class="card-body">

                                @foreach ($product as $products)
                                    <div class="d-flex justify-content-between pb-2">
                                        <div class="h6">{{ $products->prod_name }} X
                                            <b><u><i>{{ $products->cqty }}</i></u></b>
                                        </div>
                                        <div class="h6"><i class="fa fa-inr"
                                                aria-hidden="true">{{ $products->price * $products->cqty }}
                                            </i></div>
                                    </div>
                                @endforeach
                                <div class="d-flex justify-content-between summery-end">
                                    <div class="h6"><strong>Subtotal</strong></div>
                                    <div class="h6"><strong><i class="fa fa-inr"
                                                aria-hidden="true">{{ $totalSum }}</i></strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <div class="h6"><strong>Shipping</strong></div>
                                    <div class="h6"><strong>Free</strong></div>
                                </div>
                                <div class="d-flex justify-content-between mt-2 summery-end">
                                    <div class="h5"><strong>Total</strong></div>
                                    <div class="h5"><strong><i class="fa fa-inr"
                                                aria-hidden="true">{{ $totalSum }} </i></strong></div>
                                </div>
                            </div>
                        </div>


                       


                        {{-- Payment Detail --}}
                        <div class="card payment-form ">
                            <h3 class="card-title h5 mb-3">Payment Details</h3>
                            <div class="">
                                <input checked type="radio" name="payment_method" value="method"
                                    id="payment_method">
                                <label for="payment_method" class="form-check-label">Select Payment Method</label>

                                <div class="pt-4" id="CardPaymentForm">

                                </div>
                            </div>
                            <div class="">
                                <input type="radio" name="payment_method" value="cod" id="payment_method_one">
                                <label for="payment_method_one" class="form-check-label">COD</label>

                                <div class="pt-4" id="CardPaymentFormOne">
                                    <button type="submit" class="btn-dark btn btn-block w-100">{{ $totalSum }}
                                        Pay On COD </button>
                                </div>
                            </div>
            </form>

            <div class="">
                <input type="radio" name="payment_method" value="stripecard" id="payment_method_two">
                <label for="payment_method_two" class="form-check-label">Pay With Stripe</label>
                <div class="pt-4" id="CardPaymentFormTwo">
                    <form id="StripeForm" action="{{ route('stripe') }}" method="post">
                        @csrf
                        @foreach ($product as $products)
                            <input type="hidden" class="price" name="price[]" value="{{ $products->price }}">
                            <input type="hidden" class="prod_name" name="prod_name[]"
                                value="{{ $products->prod_name }}">
                            <input type="hidden" class="quantity" name="quantity[]" value="{{ $products->cqty }}">
                        @endforeach

                        <input type="hidden" name="first_name" id="stripe_first_name">
                        <input type="hidden" name="last_name" id="stripe_last_name">
                        <input type="hidden" name="email" id="stripe_email">
                        <input type="hidden" name="country" id="stripe_country">
                        <input type="hidden" name="address" id="stripe_address">
                        <input type="hidden" name="apartment" id="stripe_apartment">
                        <input type="hidden" name="city" id="stripe_city">
                        <input type="hidden" name="state" id="stripe_state">
                        <input type="hidden" name="zip" id="stripe_zip">
                        <input type="hidden" name="mobile" id="stripe_mobile">
                        <input type="hidden" name="order_notes" id="order_note">


                        <button type="submit" class="btn-dark btn btn-block w-100"
                            data-value="stripePayment">{{ $totalSum }}
                            Pay Now </button>
                    </form>
                </div>
            </div>
            <div class="">
                <input type="radio" name="payment_method" value="paypal" id="payment_method_three">
                <label for="payment_method_three" class="form-check-label">Pay With PayPal</label>
                <div class="pt-4" id="CardPaymentFormThree">
                    <form id="PaypalForm" action="{{ route('paypal') }}" method="post">
                        @csrf
                        @foreach ($product as $products)
                            <input type="hidden" class="price" name="price[]" value="{{ $products->price }}">
                            <input type="hidden" class="prod_name" name="prod_name[]"
                                value="{{ $products->prod_name }}">
                            <input type="hidden" class="quantity" name="quantity[]" value="{{ $products->cqty }}">
                        @endforeach

                        <input type="hidden" name="first_name" id="paypal_first_name">
                        <input type="hidden" name="last_name" id="paypal_last_name">
                        <input type="hidden" name="email" id="paypal_email">
                        <input type="hidden" name="country" id="paypal_country">
                        <input type="hidden" name="address" id="paypal_address">
                        <input type="hidden" name="apartment" id="paypal_apartment">
                        <input type="hidden" name="city" id="paypal_city">
                        <input type="hidden" name="state" id="paypal_state">
                        <input type="hidden" name="zip" id="paypal_zip">
                        <input type="hidden" name="mobile" id="paypal_mobile">
                        <input type="hidden" name="order_notes" id="order_note">
                        <button type="submit" class="btn-dark btn btn-block w-100">{{ $totalSum }}
                            Pay Now </button>
                    </form>
                </div>
            </div>

            <div class="">
                <input type="radio" name="payment_method" value="braintreecard" id="payment_method_four">
                <label for="payment_method_four" class="form-check-label">Pay With Braintree</label>
                <div class="pt-4" id="CardPaymentFormFour">
                    <form id="BraintreeForm" action="{{ route('braintreeCard') }}" method="">
                        <input type="hidden" name="first_name" id="braintree_first_name">
                        <input type="hidden" name="last_name" id="braintree_last_name">
                        <input type="hidden" name="email" id="braintree_email">
                        <input type="hidden" name="country" id="braintree_country">
                        <input type="hidden" name="address" id="braintree_address">
                        <input type="hidden" name="apartment" id="braintree_apartment">
                        <input type="hidden" name="city" id="braintree_city">
                        <input type="hidden" name="state" id="braintree_state">
                        <input type="hidden" name="zip" id="braintree_zip">
                        <input type="hidden" name="mobile" id="braintree_mobile">
                        <input type="hidden" name="order_notes" id="order_note">
                        <button type="submit" class="btn-dark btn btn-block w-100">{{ $totalSum }}
                            Pay Now </button>
                    </form>
                </div>
            </div>

        </div>



        </div>
        </div>
        </div>
    </section>
</main>
<script src="{{ asset('user_assets/js/ajx.js') }}"></script>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script>
    
</script>

<script>
    function populateStripeForm() {
        // Populate Stripe form with Checkout form data
        document.getElementById('stripe_first_name').value = document.getElementById('first_name').value;
        document.getElementById('stripe_last_name').value = document.getElementById('last_name').value;
        document.getElementById('stripe_email').value = document.getElementById('email').value;
        document.getElementById('stripe_country').value = document.getElementById('country').value;
        document.getElementById('stripe_address').value = document.getElementById('address').value;
        document.getElementById('stripe_apartment').value = document.getElementById('appartment').value;
        document.getElementById('stripe_city').value = document.getElementById('city').value;
        document.getElementById('stripe_state').value = document.getElementById('state').value;
        document.getElementById('stripe_zip').value = document.getElementById('zip').value;
        document.getElementById('stripe_mobile').value = document.getElementById('mobile').value;
        document.getElementById('order_notes').value = document.getElementById('order_note').value;
    }

    function populatePaypalForm() {
        // Populate PayPal form with Checkout form data
        document.getElementById('paypal_first_name').value = document.getElementById('first_name').value;
        document.getElementById('paypal_last_name').value = document.getElementById('last_name').value;
        document.getElementById('paypal_email').value = document.getElementById('email').value;
        document.getElementById('paypal_country').value = document.getElementById('country').value;
        document.getElementById('paypal_address').value = document.getElementById('address').value;
        document.getElementById('paypal_apartment').value = document.getElementById('appartment').value;
        document.getElementById('paypal_city').value = document.getElementById('city').value;
        document.getElementById('paypal_state').value = document.getElementById('state').value;
        document.getElementById('paypal_zip').value = document.getElementById('zip').value;
        document.getElementById('paypal_mobile').value = document.getElementById('mobile').value;
        document.getElementById('order_notes').value = document.getElementById('order_note').value;
    }

    function populateBraintreeForm() {
        // Populate Braintree form with Checkout form data
        document.getElementById('braintree_first_name').value = document.getElementById('first_name').value;
        document.getElementById('braintree_last_name').value = document.getElementById('last_name').value;
        document.getElementById('braintree_email').value = document.getElementById('email').value;
        document.getElementById('braintree_country').value = document.getElementById('country').value;
        document.getElementById('braintree_address').value = document.getElementById('address').value;
        document.getElementById('braintree_apartment').value = document.getElementById('appartment').value;
        document.getElementById('braintree_city').value = document.getElementById('city').value;
        document.getElementById('braintree_state').value = document.getElementById('state').value;
        document.getElementById('braintree_zip').value = document.getElementById('zip').value;
        document.getElementById('braintree_mobile').value = document.getElementById('mobile').value;
        document.getElementById('order_notes').value = document.getElementById('order_note').value;
    }


    document.getElementById('payment_method_two').addEventListener('change', function() {
        if (this.checked) {
            populateStripeForm();
        }
    });

    document.getElementById('payment_method_three').addEventListener('change', function() {
        if (this.checked) {
            populatePaypalForm();
        }
    });

    document.getElementById('payment_method_four').addEventListener('change', function() {
        if (this.checked) {
            populateBraintreeForm();
        }
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let priceInputs = document.querySelectorAll('.price');
        let prodNameInputs = document.querySelectorAll('.prod_name');
        let quantityInputs = document.querySelectorAll('.quantity');

        let originalPrices = [];
        let originalProdNames = [];
        let originalQuantities = [];

        priceInputs.forEach((input, index) => {
            originalPrices[index] = input.value;
        });

        prodNameInputs.forEach((input, index) => {
            originalProdNames[index] = input.value;
        });

        quantityInputs.forEach((input, index) => {
            originalQuantities[index] = input.value;
        });

        // Stripe
        document.querySelector("#StripeForm").addEventListener("submit", function(e) {
            // Reset values if they have been modified
            priceInputs.forEach((input, index) => {
                if (input.value !== originalPrices[index]) {
                    input.value = originalPrices[index];
                }
            });

            prodNameInputs.forEach((input, index) => {
                if (input.value !== originalProdNames[index]) {
                    input.value = originalProdNames[index];
                }
            });

            quantityInputs.forEach((input, index) => {
                if (input.value !== originalQuantities[index]) {
                    input.value = originalQuantities[index];
                }
            });
        });

        //PayPal
        document.querySelector("#PaypalForm").addEventListener("submit", function(e) {
            // Reset values if they have been modified
            priceInputs.forEach((input, index) => {
                if (input.value !== originalPrices[index]) {
                    input.value = originalPrices[index];
                }
            });

            prodNameInputs.forEach((input, index) => {
                if (input.value !== originalProdNames[index]) {
                    input.value = originalProdNames[index];
                }
            });

            quantityInputs.forEach((input, index) => {
                if (input.value !== originalQuantities[index]) {
                    input.value = originalQuantities[index];
                }
            });
        });

        //Braintree
        // document.querySelector("#BraintreeForm").addEventListener("submit", function(e) {
        //     // Reset values if they have been modified
        //     priceInputs.forEach((input, index) => {
        //         if (input.value !== originalPrices[index]) {
        //             input.value = originalPrices[index];
        //         }
        //     });

        //     prodNameInputs.forEach((input, index) => {
        //         if (input.value !== originalProdNames[index]) {
        //             input.value = originalProdNames[index];
        //         }
        //     });

        //     quantityInputs.forEach((input, index) => {
        //         if (input.value !== originalQuantities[index]) {
        //             input.value = originalQuantities[index];
        //         }
        //     });
        // });
    });
</script>







<script type="text/javascript">
    $(function() {



        /*------------------------------------------

        --------------------------------------------

        Stripe Payment Code

        --------------------------------------------

        --------------------------------------------*/



        var $form = $(".require-validation");



        $('form.require-validation').bind('submit', function(e) {

            var $form = $(".require-validation"),

                inputSelector = ['input[type=email]', 'input[type=password]',

                    'input[type=text]', 'input[type=file]',

                    'textarea'
                ].join(', '),

                $inputs = $form.find('.required').find(inputSelector),

                $errorMessage = $form.find('div.error'),

                valid = true;

            $errorMessage.addClass('hide');



            $('.has-error').removeClass('has-error');

            $inputs.each(function(i, el) {

                var $input = $(el);

                if ($input.val() === '') {

                    $input.parent().addClass('has-error');

                    $errorMessage.removeClass('hide');

                    e.preventDefault();

                }

            });



            if (!$form.data('cc-on-file')) {

                e.preventDefault();

                Stripe.setPublishableKey($form.data('stripe-publishable-key'));

                Stripe.createToken({

                    number: $('#card_number').val(),

                    cvc: $('#cvv').val(),

                    exp_month: $('#expiry_month').val(),

                    exp_year: $('#expiry_year').val()

                }, stripeResponseHandler);

            }



        });



        /*------------------------------------------

        --------------------------------------------

        Stripe Response Handler

        --------------------------------------------

        --------------------------------------------*/

        function stripeResponseHandler(status, response) {

            if (response.error) {

                $('.error')

                    .removeClass('hide')

                    .find('.alert')

                    .text(response.error.message);

            } else {

                /* token contains id, last4, and card type */

                var token = response[$userId];



                $form.find('input[type=text]').empty();

                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");

                $form.get(0).submit();

            }

        }



    });
</script>

@include('user.includes.footer')
