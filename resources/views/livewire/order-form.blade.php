<form wire:submit.prevent="submit">
    <div>
        @if ($productId)
            <p>주문 상품 ID: {{ $productId }}</p>
            <p>상품명: {{ $product->name }}</p>
            {{-- <p>설명: {{ $product->description }}</p>--}}
            <p>가격: {{ $product->price }} 원</p>

            <label>
                고객이름
                <input type="text" wire:model="quantity" placeholder="개수">
            </label>
            <label>
                상태 - 개발용
                <input type="text" wire:model="status" placeholder="상태 - 개발용">
            </label>
            <label>
                고객 이름
                <input type="text" wire:model="customerName" placeholder="고객 이름">
            </label>
            <label>
                주소
                <input type="text" wire:model="address" placeholder="주소">
            </label>
            <button type="submit">결제하기</button>
        @else
            <p>주문할 상품이 없습니다.</p>
        @endif
    </div>
</form>
