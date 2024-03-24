<form wire:submit.prevent="submit">
    <input type="text" wire:model="customer_name" placeholder="고객 이름" value="이필립">
    <textarea wire:model="address" placeholder="주소" value="서울시 맨허튼구 봉천동 402번지"></textarea>
    <input type="text" wire:model="total" placeholder="총액" value="3500000" readonly>
    <button type="submit">주문하기</button>
</form>
