<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrderFormComponent extends Component
{
    public function mount($productId)
    {
        $this->productId = $productId;
        $this->quantity = 1; // 기본값
    }

    public function submit()
    {
        Order::create([
                          'product_id' => $this->productId,
                          'quantity' => $this->quantity,
                      ]);

        // 주문 처리 후 로직
    }

    public function render()
    {
        return view('livewire.order-form-component');
    }
}
