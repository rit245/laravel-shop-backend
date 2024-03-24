<div>
    <h2>상품 리스트</h2>
    <ul>
        @foreach ($products as $product)
            <li>
                <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                    {{ $product->name }} - ${{ $product->price }}
                </a>
                <p>{{ $product->description }}</p>
            </li>
        @endforeach
    </ul>
</div>
