<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;

class OrderCreate extends Component
{
    public $product, $amount, $buyer_email, $buyer_name;

    public function submit()
    {
        $this->validate([
                            'product' => 'required',
                            'amount' => 'required|numeric',
                            'buyer_email' => 'required|email',
                            'buyer_name' => 'required',
                        ]);

        Order::create([
                          'product' => $this->product,
                          'amount' => $this->amount,
                          'buyer_email' => $this->buyer_email,
                          'buyer_name' => $this->buyer_name,
                      ]);

        session()->flash('message', 'Order successfully created.');

        $this->reset(['product', 'amount', 'buyer_email', 'buyer_name']);
    }

    public function render()
    {
        return view('livewire.order-create');
    }
}
