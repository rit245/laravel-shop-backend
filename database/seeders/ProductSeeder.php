<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $admins = DB::table('admins')->pluck('id')->toArray();

        // 20개의 상품 데이터 생성
        for ($i = 0; $i < 20; $i++) {
            Product::create([
                'name' => $faker->word,
                'description' => $faker->paragraph,
                'price' => $faker->numberBetween(1000, 10000), // 1,000에서 10,000 사이의 가격
                'reg_admin_id' => $faker->randomElement($admins),
            ]);
        }
    }
}
