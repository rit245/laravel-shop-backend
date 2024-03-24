<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // 대량 할당이 가능한 필드를 정의합니다.
    protected $fillable = ['user_id', 'product_id', 'quantity', 'status'];

    public static function create(array $array): Order
    {
        // 주문 생성 로직
        $order = new self();
        $order->fill($array);

        // 주문 완료 상태로 설정
        $order->status = 'complete';

        $order->save(); // 데이터베이스에 주문 정보 저장

        return $order; // 생성된 주문 인스턴스 반환
    }

    /**
     * 이 주문과 관련된 사용자를 가져옵니다.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 이 주문과 관련된 상품을 가져옵니다.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
