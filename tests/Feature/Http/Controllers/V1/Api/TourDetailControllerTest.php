<?php

namespace Tests\Feature\Http\Controllers\V1\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TourDetailControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_should_return_tour_detail(): void
    {
        $user = $this->makeUser()->create();
        $tour = $this->makeTour()->create([
            'user_id' => $user->id
        ]);
        $response = $this->getJson(route('tours.detail.slug', ['tour' => $tour]));

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'data' => [
                'title',
                'slug',
                'location',
                'overview',
                'price'
            ]
        ]);
    }
}
