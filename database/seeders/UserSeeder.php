<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('users')->insert([
               'name' => $faker->name,
               'email' => $faker->unique()->safeEmail,
               'email_verified_at' => now(),
               'password' => Hash::make('password'), // 테스트용, 같은 비번 생성됨
               'remember_token' => Str::random(10),
           ]);
        }
    }
}
