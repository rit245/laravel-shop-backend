<div>
    @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="submit">
        <input type="text" wire:model="product" placeholder="상품명">
        @error('product') <span class="error">{{ $message }}</span> @enderror

        <input type="number" wire:model="amount" placeholder="금액">
        @error('amount') <span class="error">{{ $message }}</span> @enderror

        <input type="email" wire:model="buyer_email" placeholder="구매자 이메일">
        @error('buyer_email') <span class="error">{{ $message }}</span> @enderror

        <input type="text" wire:model="buyer_name" placeholder="구매자 이름">
        @error('buyer_name') <span class="error">{{ $message }}</span> @enderror

        <button type="submit">주문 생성</button>
    </form>
</div>
