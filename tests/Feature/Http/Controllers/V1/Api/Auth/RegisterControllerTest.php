<?php

namespace Http\Controllers\V1\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_register_user_using_auth_api(): void
    {
        $payload = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
            'gender' => 1,
            'nationality' => 'Indonesia',
            'primary_lang' => 'English',
            'other_lang' => 'Tamil, Malay',
        ];

        $response = $this->postJson(route('auth.register'), $payload);

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'message',
                'user' => ['id', 'name', 'email', 'gender', 'nationality', 'primary_lang', 'other_lang', 'status']
            ]
        ]);
    }

    #[Test]
    public function it_should_validate_the_register_request(): void
    {
        $response = $this->postJson(route('auth.register'), []);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'first_name',
            'last_name',
            'password',
            'password_confirmation',
        ]);
    }

    #[Test]
    public function it_should_validate_the_password_confirmation()
    {
        $payload = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'invalid_password',
            'gender' => 1,
        ];

        $response = $this->postJson(route('auth.register'), $payload);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrorFor('password');

    }
}
