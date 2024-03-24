<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>홈</title>
    @vite(['resources/css/app.css'])
    <script src="https://cdn.portone.io/v2/browser-sdk.js"></script>
</head>

<body>
@livewire('header')

<div class="container" style="margin-top: 20px;">
    @livewire('order-form', ['productId' => $productId ?? null])
</div>

@livewire('footer')
</body>
</html>
