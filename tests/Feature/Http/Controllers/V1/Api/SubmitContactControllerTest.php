<?php

namespace Tests\Feature\Http\Controllers\V1\Api;

use App\Jobs\SubmitContactJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubmitContactControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function is_should_submit_contact_us()
    {
        Queue::fake();

        $payload = [
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'message' => $this->faker->sentence
        ];

        $response = $this->postJson(route('contact.submit'), $payload);
        $response->assertSuccessful();

        Queue::assertPushed(SubmitContactJob::class);

    }

    #[Test]
    public function is_should_validate_submit_contact_us()
    {
        $payload = [
            'name' => $this->faker->name,
        ];

        $response = $this->postJson(route('contact.submit'), $payload);
        $response->assertJsonValidationErrors([
            'email',
            'message'
        ]);
    }
}
