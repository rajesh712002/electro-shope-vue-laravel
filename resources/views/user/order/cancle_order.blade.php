<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Email</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">

    <h1 style="color: red">
         Your Order Canclled Successfully||
        <br>
        Within 7 Day We Refund Your Amount.
    </h1>
    <h2>
        Your Order Id Is: #{{ $mailData['order']->id }}
    </h2>
    <h2>Products</h2>

    <table cellpadding="3" cellspacing="3" border="1">
        <thead>
            <tr style="background: #CCC;">
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>

            </tr>
        </thead>
        <tbody>
            @if (!empty($mailData['order']))
                @foreach ($mailData['order']->orderItem as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td><i class="fa fa-inr" aria-hidden="true"></i> {{ $item->price }}</td>
                        <td>{{ $item->qty }}</td>
                        <td><i class="fa fa-inr" aria-hidden="true"></i> {{ $item->total }}</td>
                    </tr>
                @endforeach

                <tr>
                    <th colspan="3" align="right">Subtotal</th>
                    <td>{{ $mailData['order']->subtotal }}</td>
                </tr>
                <tr>
                    <th colspan="3" align="right">Discount</th>
                    <td>{{ $mailData['order']->discount }}</td>
                </tr>
               
                <tr>
                    <th colspan="3" align="right">Total</th>
                    <td>{{ $mailData['order']->grand_total }}</td>
                </tr>
                <tr>
                    <th colspan="3" align="right">Pyment Type</th>
                    <td>{{ $mailData['order']->payment_status }}</td>
                </tr>

                <tr>
                    <th colspan="3" align="right">Status</th>
                    <td class="btn btn-close" style="color: red">{{ $mailData['order']->status }}</td>
                </tr>

                <tr>
                    <th colspan="3">Date </th>
                    <td><time datetime="2019-10-01">
                            {{ \Carbon\Carbon::parse($mailData['order']->updated_at)->format('d M, Y') }}
                        </time></td>
                </tr>

            @endif
        </tbody>
    </table>
</body>

</html>
