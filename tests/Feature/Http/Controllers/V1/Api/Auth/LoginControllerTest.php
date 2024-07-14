<?php

namespace Http\Controllers\V1\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_login_user_using_auth_api(): void
    {
        $password = 'password';
        $user = $this->makeUser()->create(['password' => Hash::make($password)]);

        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    #[Test]
    public function it_cant_login_user_using_auth_api_for_invalid_credentials(): void
    {
        $password = 'password';
        $user = $this->makeUser()->create(['password' => Hash::make($password)]);

        $response = $this->post(route('auth.login'), [
            'email' => $user->email,
            'password' => 'invalid password',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    #[Test]
    public function it_should_validate_the_email_and_password_confirmation()
    {
        $response = $this->postJson(route('auth.login'), []);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors(['email', 'password']);

    }

    #[Test]
    public function it_should_validate_the_email_with_database()
    {
        $response = $this->postJson(route('auth.login'), [
            'email' => 'test@gmail.com',
            'password' => 'invalid password',
        ]);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrorFor('email');

    }
}
