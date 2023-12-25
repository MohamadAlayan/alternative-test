<?php

namespace Tests\Api\Admin\Auth;

use App\Enums\HttpCode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test login with valid credentials
     *
     * @return void
     */
    public function testLoginWithValidCredentials(): void
    {
        $response = $this->postJson(route('admin.login'), [
            'email' => 'mohamadalayanlb@gmail.com',
            'password' => '12345678',
        ]);
        $response->assertStatus(HttpCode::OK->value);
    }

    /**
     * Test login with invalid credentials
     *
     * @return void
     */
    public function testLoginWithWrongCredentials(): void
    {
        $response = $this->postJson(route('admin.login'), [
            'email' => 'mohamadalayanlb@gmail.com',
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(HttpCode::UNAUTHORIZED->value);
    }

    /**
     * Test login with missing fields
     *
     * @return void
     */
    public function testLoginWithMissingFields(): void
    {
        $response = $this->postJson(route('admin.login'), [
            'email' => '',
            'password' => '',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                "success" => false,
                "error" => [
                    "code" => 422,
                    "message" => "Email is required (and 1 more error)",
                    "reason" => [
                        "email" => [
                            "Email is required"
                        ],
                        "password" => [
                            "Password is required"
                        ]
                    ]
                ]
            ]);
    }

}
