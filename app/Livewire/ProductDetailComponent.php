<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductDetailComponent extends Component
{
    public function mount($productId)
    {
        $this->productId = $productId;
    }

    public function render()
    {
        $product = Product::find($this->productId);
        return view('livewire.product-detail-component', ['product' => $product]);
    }
}
