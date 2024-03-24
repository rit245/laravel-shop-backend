<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class OrderSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $users = DB::table('users')->pluck('id')->toArray();
        $products = DB::table('products')->pluck('id')->toArray();

        foreach (range(1, 15) as $index) {
            DB::table('orders')->insert([
                'product_id' => $faker->randomElement($products),
                'user_id' => $faker->randomElement($users),
                'quantity' => $faker->numberBetween(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
                'status' => $faker->randomElement(['completed', 'failed', 'cancelled' , 'pending' ]),
            ]);
        }
    }
}
