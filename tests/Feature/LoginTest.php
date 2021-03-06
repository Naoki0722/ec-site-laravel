<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // ユーザーログイン成功
    public function testLoginUser()
    {
        $user = User::factory()->make();
        $response = $this->json('POST', '/api/login', [
            'email' => $user->email,
        ]);
        $response->assertStatus(200);
        
    }
    // メールアドレスが異なればログインできない
    public function testFailedLoginUser()
    {
        $user = User::factory()->make();
        $response = $this->json('POST', '/api/login', [
            'email' => 'test@test.com',
        ]);
        $response->assertStatus(500);
        
    }
}
