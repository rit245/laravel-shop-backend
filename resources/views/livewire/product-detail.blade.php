<div>
    <h2>{{ $product->name }}</h2>
    <p>가격: {{ $product->price }}원</p>
    <div>{{ $product->description }}</div>

    <button wire:click="addToCart({{ $product->id }})">장바구니에 추가</button>
    <button wire:click="placeOrder({{ $product->id }})">주문하기</button>

</div>
