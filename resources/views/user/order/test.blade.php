<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <form action="{{route('stripe')}}" method="post">
        @csrf
        
        <input type="hidden" name="price" value="77">
        <input type="hidden" name="prod_name" value="Watch">
        <input type="hidden" name="quantity" value="1">
        <button type="submit">Pay with Stripe</button>

    </form>
</body>
</html>

