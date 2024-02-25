<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /** @test */
    public function 회원가입을_할_수_있다()
    {
        $email = $this->faker->unique()->safeEmail;

        $response = $this->postJson('/api/register', [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', ['email' => $email]);
    }

    /** @test */
    public function 유저가_회원정보_수정을_할_수_있다()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson('/api/user/update', [
            'name' => $this->faker->name,
            'email' => $user->email,
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => $response->json('name')]);
    }

    /** @test */
    public function 유저가_회원탈퇴를_할_수_있다()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->deleteJson('/api/user/destroy');

        $response->assertStatus(200);
        $this->assertModelMissing($user);
    }

    /** @test */
    public function 유저가_로그아웃을_할_수_있다()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson('/api/logout');

        $response->assertStatus(200);
    }
}
