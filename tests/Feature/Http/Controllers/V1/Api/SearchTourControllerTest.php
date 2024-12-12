<?php

namespace Tests\Feature\Http\Controllers\V1\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SearchTourControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_search_tours_form_api(): void
    {
        $this->makeTour()->create(['title' => 'Test Tour']);
        $this->makeTour(10)->create();

        $response = $this->getJson(route('tours.search', [
            'search' => 'Test'
        ]));

        $response->assertSuccessful();
        $response->assertSeeText('Test');
    }
}
