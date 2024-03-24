<div>
    <h2>상품 리스트</h2>
    <ul>
        @foreach ($products as $product)
            <li>
                {{ $product->name }} - ${{ $product->price }}
                <p>{{ $product->description }}</p>
            </li>
        @endforeach
    </ul>
</div>
