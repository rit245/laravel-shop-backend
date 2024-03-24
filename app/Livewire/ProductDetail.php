<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductDetail extends Component
{
    public $productId;

    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function render()
    {
        $product = Product::find($this->productId);

        return view('livewire.product-detail', ['product' => $product]);
    }

    public function addToCart($productId)
    {
        session()->flash('message', '상품이 장바구니에 추가되었습니다.');
    }

    public function placeOrder($productId)
    {
        return redirect()->route('order.index', ['productId' => $productId]);

        // 결제 완료 리디렉션은 이거
        // return redirect()->to('/order-complete');
    }
}
