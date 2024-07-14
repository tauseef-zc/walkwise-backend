<?php

namespace Http\Controllers\V1\Api\Auth;

use App\Notifications\Auth\ForgotPasswordNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ForgotPasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_validate_the_forgot_password_request(): void
    {
        $payload = [
            'email' => 'test@test.com',
        ];
        $response = $this->postJson(route('auth.forgot.password'), $payload);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrorFor('email');
    }

    #[Test]
    public function it_can_validate_the_forgot_password_request_without_email(): void
    {
        $response = $this->postJson(route('auth.forgot.password'));

        $response->assertUnprocessable();
        $response->assertJsonValidationErrorFor('email');
    }

    #[Test]
    public function it_can_send_email_for_forgot_password_request(): void
    {
        Notification::fake();

        $user = $this->makeUser()->create();
        $response = $this->postJson(route('auth.forgot.password'), ['email' => $user->email]);

        $response->assertOk();
        Notification::assertSentTo($user, ForgotPasswordNotification::class);
    }
}
