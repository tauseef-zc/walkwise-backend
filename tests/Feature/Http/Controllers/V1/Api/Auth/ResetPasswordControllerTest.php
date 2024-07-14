<?php

namespace Http\Controllers\V1\Api\Auth;

use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ResetPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_validate_reset_password_request_without_token(): void
    {
        $response = $this->putJson(route('auth.reset.password'), []);
        $response->assertUnauthorized();
    }

    #[Test]
    public function it_can_validate_reset_password_request_with_token(): void
    {
        $user = $this->makeUser()->create();
        $token =  $user->createToken($user->id, ['reset.password'])->plainTextToken;

        $response = $this->withToken($token)->putJson(route('auth.reset.password'), []);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'email', 'password'
        ]);
    }

    #[Test]
    public function it_can_submit_reset_password_with_auth_api(): void
    {
        $user = $this->makeUser()->create();
        $token =  $user->createToken($user->id, ['reset.password'])->plainTextToken;

        $payload = [
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->withToken($token)->putJson(route('auth.reset.password'), $payload);

        $response->assertSuccessful();
        $response->assertSeeText('Password has been reset');
    }

    #[Test]
    public function it_can_notify_user_while_submitting_reset_password(): void
    {
        Notification::fake();

        $user = $this->makeUser()->create();
        $token =  $user->createToken($user->id, ['reset.password'])->plainTextToken;

        $payload = [
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->withToken($token)->putJson(route('auth.reset.password'), $payload);
        $response->assertSuccessful();

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }
}
