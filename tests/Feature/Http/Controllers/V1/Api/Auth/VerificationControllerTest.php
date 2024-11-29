<?php

namespace Http\Controllers\V1\Api\Auth;

use App\Jobs\Auth\VerifyUserEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class VerificationControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_validate_send_verification_mail_api(): void
    {
        $response = $this->postJson(route('auth.verification.send'), []);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'email' => 'The email field is required.'
        ]);
    }

    #[Test]
    public function it_can_validate_send_verification_mail_api_with_user(): void
    {
        $response = $this->postJson(route('auth.verification.send'), ['email' => 'test@test.com']);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'email' => 'The selected email is invalid.'
        ]);
    }

    #[Test]
    public function it_can_send_verification_mail_with_auth_api(): void
    {
        $user = $this->makeUser()->create();

        $response = $this->postJson(route('auth.verification.send'), ['email' => $user->email]);
        $response->assertOk();
    }

    #[Test]
    public function it_should_dispatch_verify_user_email_job_for_send_verification_api(): void
    {
        Queue::fake();

        $user = $this->makeUser()->create();
        $response = $this->postJson(route('auth.verification.send'), ['email' => $user->email]);

        $response->assertOk();
        Queue::assertPushed(VerifyUserEmail::class);
    }

    #[Test]
    public function it_can_validate_verify_user_using_auth_api(): void
    {
        $response = $this->postJson(route('auth.verify.user'), []);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'email', 'otp'
        ]);
    }

    #[Test]
    public function it_can_validate_verify_user_using_auth_api_with_user(): void
    {
        $response = $this->postJson(route('auth.verify.user'), ['email' => 'test@test.com']);

        $response->assertUnprocessable();
        $response->assertJsonValidationErrors([
            'email' => 'The selected email is invalid.'
        ]);
    }

    #[Test]
    public function it_can_validate_verify_user_using_auth_api_with_otp(): void
    {
        $user = $this->makeUser()->unverified()->create();
        $otp = $this->makeOtp()->create()->otp;
        $payload = [
            'email' => $user->email,
            'otp' => $otp,
            'verify_email' => true
        ];

        $response = $this->postJson(route('auth.verify.user'),$payload);

        $response->assertBadRequest();
        $response->assertSeeText('The otp is incorrect.');
    }

    #[Test]
    public function it_can_send_verify_user_using_auth_api(): void
    {
        $user = $this->makeUser()->unverified()->create();
        $otp = $user->createOtp()->otp;
        $payload = [
            'email' => $user->email,
            'otp' => $otp,
            'verify_email' => true
        ];

        $response = $this->postJson(route('auth.verify.user'), $payload);
        $user->refresh();

        $response->assertSuccessful();
        $this->assertTrue($user->hasVerifiedEmail());
    }
}
