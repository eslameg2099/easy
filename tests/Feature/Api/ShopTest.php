<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_shops()
    {
        $this->actingAsAdmin();

        Shop::factory()->count(2)->create();

        $this->getJson(route('api.shops.index'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'name',
                    ],
                ],
            ]);
    }

    /** @test */
    public function test_shops_select2_api()
    {
        Shop::factory()->count(5)->create();

        $response = $this->getJson(route('api.shops.select'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 1);

        $this->assertCount(5, $response->json('data'));

        $response = $this->getJson(route('api.shops.select', ['selected_id' => 4]))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 4);

        $this->assertCount(5, $response->json('data'));
    }

    /** @test */
    public function it_can_display_the_shop_details()
    {
        $this->actingAsAdmin();

        $shop = Shop::factory(['name' => 'Foo'])->create();

        $response = $this->getJson(route('api.shops.show', $shop))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ],
            ]);

        $this->assertEquals($response->json('data.name'), 'Foo');
    }
}
