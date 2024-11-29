<?php

namespace Http\Controllers\V1\Api\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_should_return_logged_user_for_auth_api(): void
    {
        $user = $this->makeUser()->create();
        $response = $this->actingAs($user)->getJson(route('auth.user'));

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'id', 'name', 'email', 'gender', 'status', 'verified'
                ]
            ]
        ]);
    }

    #[Test]
    public function it_should_return_user_is_user_is_unauthenticated(): void
    {
        $response = $this->getJson(route('auth.user'));
        $response->assertUnauthorized();
    }
}
