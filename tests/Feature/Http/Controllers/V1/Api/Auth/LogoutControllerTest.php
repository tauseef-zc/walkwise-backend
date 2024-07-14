<?php

namespace Http\Controllers\V1\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LogoutControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_should_logout_the_user_using_auth_api(): void
    {
        $user = $this->makeUser()->create();
        $user->createToken('test-token');

        $response = $this->actingAs($user)->getJson(route('auth.logout'));

        $response->assertSuccessful();
        $response->assertJson([
            'message' => 'Successfully logged out.'
        ]);

        $this->assertCount(0, $user->tokens);

    }

    #[Test]
    public function unauthenticated_user_cannot_logout():void
    {
        $response = $this->postJson('/api/logout');
        $response->assertNotFound();
    }

}
