<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>장바구니</title>
</head>
<body>
<h1>장바구니</h1>
<ul>
    @foreach ($carts as $cart)
        <li>{{ $cart->product_name }}: {{ $cart->quantity }}개</li>
    @endforeach
</ul>
</body>
</html>
