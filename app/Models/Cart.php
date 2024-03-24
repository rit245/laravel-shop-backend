<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'product_id', 'quantity'];

    /**
     * 이 장바구니 항목과 관련된 사용자를 가져옵니다.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 이 장바구니 항목과 관련된 상품을 가져옵니다.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
