<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Shop;
use App\Models\Product;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_products()
    {
        $this->actingAsAdmin();

        Product::factory()->count(2)->create();

        $this->getJson(route('api.products.index'))
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
    public function test_products_select2_api()
    {
        Product::factory()->count(5)->create();

        $response = $this->getJson(route('api.products.select'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 1);

        $this->assertCount(5, $response->json('data'));

        $response = $this->getJson(route('api.products.select', ['selected_id' => 4]))
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
    public function it_can_display_the_product_details()
    {
        $this->actingAsAdmin();

        $product = Product::factory(['name' => 'Foo'])->create();

        $response = $this->getJson(route('api.products.show', $product))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ],
            ]);

        $this->assertEquals($response->json('data.name'), 'Foo');
    }

    /** @test */
    public function the_shop_owner_can_create_a_new_product()
    {
        Storage::fake('public');

        $this->actingAsCustomer();

        $response = $this->postJson(
            route('dashboard.products.store'),
            Product::factory()->raw([
                'name' => 'Foo',
            ])
        );

        $response->assertForbidden();

        Shop::factory(['user_id' => $this->actingAsShopOwner()])->create();

        $response = $this->postJson(
            route('api.products.store'),
            Product::factory()->raw([
                'name' => 'Foo',
                'images' => [
                    UploadedFile::fake()->image('01.png'),
                    UploadedFile::fake()->image('02.png'),
                ],
            ])
        );

        $response->assertSuccessful();

        $this->assertEquals($response->json('data.name'), 'Foo');
        $this->assertCount(2, $response->json('data.images'));
    }

    /** @test */
    public function it_can_lock_or_unlock_products()
    {
        $shop = Shop::factory(['user_id' => $owner = $this->actingAsShopOwner()])->create();

        $product = Product::factory(['shop_id' => $shop->id])->create();

        $this->assertFalse($product->locked());

        $response = $this->patchJson(route('api.products.lock', $product))->assertSuccessful();

        $this->assertTrue($product->refresh()->locked());

        $this->assertTrue($response->json('data.locked'));

        $response = $this->patchJson(route('api.products.lock', $product))->assertSuccessful();

        $this->assertFalse($product->refresh()->locked());

        $this->assertFalse($response->json('data.locked'));
    }
}
