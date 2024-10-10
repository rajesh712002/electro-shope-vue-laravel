<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Braintree Payment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .payment-container {
            width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        button {
            background-color: #007bff;
            color: white;
            font-size: 16px;
            cursor: pointer;
            border: none;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 10px;
            margin-bottom: 10px;
            color: white;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #28a745;
        }

        .alert-danger {
            background-color: #dc3545;
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <h2>Braintree Payment</h2>

        <form id="payment-form" method="post" action="{{ route('braintree') }}">
            @csrf
            <label for="amount">Amount</label>
            <input type="text" id="amount" name="amount" value="{{ $totalSum }}" readonly>

            <label for="dropin-container">Payment Details</label>
            <div id="dropin-container"></div>

            <input type="hidden" id="nonce" name="payment_method_nonce" />
            <button type="submit">Pay</button>
        </form>
    </div>

    <script src="https://js.braintreegateway.com/web/dropin/1.32.0/js/dropin.min.js"></script>
    <script>
        var form = document.querySelector('#payment-form');
        var client_token = "{{ $token }}";

        braintree.dropin.create({
            authorization: client_token,
            container: '#dropin-container',
            card: {
                cardholderName: true
            }
        }, function(createErr, instance) {
            if (createErr) {
                console.log('Create Error', createErr);
                return;
            }

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                instance.requestPaymentMethod(function(err, payload) {
                    if (err) {
                        console.log('Request Payment Method Error', err);
                        return;
                    }

                    document.querySelector('#nonce').value = payload.nonce;
                    form.submit();
                });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            const amountInput = document.querySelector("#amount");
            const originalAmount = amountInput.value;
            document.querySelector("#payment-form").addEventListener("submit", function(e) {
                // Check if the amount input value has been modified
                if (amountInput.value !== originalAmount) {
                    amountInput.value = originalAmount;
                }
            });
        });



    </script>
</body>

</html>
