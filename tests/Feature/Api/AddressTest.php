<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Address;
use App\Support\SettingJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_addresses()
    {
        $this->actingAsAdmin();

        Address::factory()->count(2)->create();

        $this->getJson(route('api.addresses.index'))
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
    public function test_addresses_select2_api()
    {
        Address::factory()->count(5)->create();

        $response = $this->getJson(route('api.addresses.select'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 1);

        $this->assertCount(5, $response->json('data'));

        $response = $this->getJson(route('api.addresses.select', ['selected_id' => 4]))
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
    public function it_can_display_the_address_details()
    {
        $this->actingAsAdmin();

        $address = Address::factory(['name' => 'Foo'])->create();

        $response = $this->getJson(route('api.addresses.show', $address))
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
