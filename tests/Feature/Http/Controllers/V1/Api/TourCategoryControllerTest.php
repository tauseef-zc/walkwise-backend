<?php

namespace Tests\Feature\Http\Controllers\V1\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class TourCategoryControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function  it_should_get_category_by_slug(): void
    {
        $category = $this->makeTourCategory()->create();
        $response = $this->getJson(route('tour_categories.single', ['slug' => $category->slug]));

        $response->assertSuccessful();
        $response->assertJsonStructure([
            'id',
            'slug',
            'info'
        ]);
    }

    #[Test]
    public function it_should_return_categories(): void
    {
        $this->makeTourCategory()->create();
        $response = $this->getJson(route('tour_categories.index'));

        $response->assertSuccessful();
        $response->assertJsonStructure([
            [
                'id',
                'slug',
                'info'
            ]
        ]);
    }
}
