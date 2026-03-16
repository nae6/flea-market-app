<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * ログイン画面の表示
     */
    public function test_display_login_view(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * ユーザーがログインできるか
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('index'));

        $this->assertAuthenticatedAs($user);
    }
}
