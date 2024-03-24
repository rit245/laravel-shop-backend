<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Order;

class OrderForm extends Component
{
    public $quantity = 1;
    public $status = 'pending'; // 기본 상태는 'pending'으로 설정
    public $productId;
    public $product;
    public $customerName = '김말손';
    public $address = '강해보이는 주소';
    public $total = 0;


    protected $rules = [
        'productId' => 'required|exists:products,id',
        'quantity' => 'required|integer|min:1',
        'status' => 'in:pending,completed,cancelled', // 허용되는 상태 값
    ];

    public function submit()
    {
        // $this->createOrder(); // 주문 생성 로직
        $this->accessBillingApi(); // 결제 API 접근 로직
    }

    private function accessBillingApi()
    {
        // 결제 API에 접근하는 로직

        $this->js('await PortOne.requestPayment({
        // Store ID 설정
        storeId: "123456",
        // 채널 키 설정
        channelKey: "YOUR_CHANNEL_KEY",
        paymentId: `payment-${crypto.randomUUID()}`,
        orderName: "파는 무언가",
        totalAmount:1000,
        currency:"CURRENCY_KRW",
        payMethod:"CARD",
        }).then((response) => {
          alert(response);
        }).catch((error) => {
          alert(error);
        });');

    }

    private function createOrder(){

        $this->validate();

        Order::create([
                          //user_id' => Auth::id(),
                          'user_id' => "1",
                          // 현재 로그인한 사용자의 ID
                          'product_id' => $this->productId,
                          'quantity' => $this->quantity,
                          'status' => $this->status,
                      ]);

        // 성공 메시지와 함께 다른 페이지로 리디렉션하거나, 현재 페이지에서 성공 알림을 표시
        session()->flash('message', '주문이 성공적으로 생성되었습니다.');

        // 결제 완료 리디렉션
        return redirect()->route('order-complete');
    }


    public function mount($productId = null)
    {
        $this->productId = $productId;

        // 상품 ID가 있으면 상품 정보 로드
        if (!is_null($this->productId)) {
            $this->product = Product::find($this->productId);
            $this->total = $this->product ? $this->product->price : 0;
        }
    }


    public function render()
    {
        return view('livewire.order-form');
    }
}
