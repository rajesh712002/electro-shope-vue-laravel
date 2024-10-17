<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body style="font-family: Arial, Helvetica, sans-serif; font-size:16px;">
    <h1>
        Your Order Id Is: #{{ $mailData['order']->id }}
    </h1>
    <h2 style="color: red">
        Your Order Refunded Successfully||
        <br>
        Within 7 Day Refund Will be Deposited In Your link Account
    </h2>
</body>

</html>
