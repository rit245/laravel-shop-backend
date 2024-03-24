<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Faker\Factory as Faker;

class CartSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        // 모든 사용자와 상품의 ID를 가져옴
        $userIds = User::pluck('id')->toArray();
        $productIds = Product::pluck('id')->toArray();

        // 사용자 또는 상품이 없는 경우, 경고 메시지 출력
        if (empty($userIds) || empty($productIds)) {
            echo "사용자 또는 상품이 데이터베이스에 없어요.\n";
            return;
        }

        // 예시로 20개의 장바구니 항목을 생성
        for ($i = 0; $i < 20; $i++) {
            Cart::create([
                 'user_id' => $faker->randomElement($userIds),
                 'product_id' => $faker->randomElement($productIds),
                 'quantity' => $faker->numberBetween(1, 5), // 1부터 5 사이의 무작위 수량
             ]);
        }
    }
}
