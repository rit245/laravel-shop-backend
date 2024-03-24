<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrderForm extends Component
{
    public $customer_name;
    public $address;
    public $total;

    public function submit()
    {
        $this->validate([
                            'customer_name' => 'required',
                            'address' => 'required',
                            'total' => 'required|numeric',
                        ]);

        Order::create([
                          'customer_name' => $this->customer_name,
                          'address' => $this->address,
                          'total' => $this->total,
                      ]);

        // 초기화 또는 추가 동작
    }

    public function render()
    {
        return view('livewire.order-form');
    }
}
