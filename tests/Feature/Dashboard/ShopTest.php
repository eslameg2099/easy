<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Shop;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShopTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_a_list_of_shops()
    {
        $this->actingAsAdmin();

        Shop::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.shops.index'))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_the_shop_details()
    {
        $this->actingAsAdmin();

        $shop = Shop::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.shops.show', $shop))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_shops_create_form()
    {
        $this->actingAsAdmin();

        $this->get(route('dashboard.shops.create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_a_new_shop()
    {
        $this->actingAsAdmin();

        $shopsCount = Shop::count();

        $response = $this->post(
            route('dashboard.shops.store'),
            Shop::factory()->raw([
                'name' => 'Foo',
            ])
        );

        $response->assertRedirect();

        $shop = Shop::all()->last();

        $this->assertEquals(Shop::count(), $shopsCount + 1);

        $this->assertEquals($shop->name, 'Foo');
    }

    /** @test */
    public function it_can_display_the_shops_edit_form()
    {
        $this->actingAsAdmin();

        $shop = Shop::factory()->create();

        $this->get(route('dashboard.shops.edit', $shop))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_update_the_shop()
    {
        $this->actingAsAdmin();

        $shop = Shop::factory()->create();

        $response = $this->put(
            route('dashboard.shops.update', $shop),
            Shop::factory()->raw([
                'name' => 'Foo',
            ])
        );

        $shop->refresh();

        $response->assertRedirect();

        $this->assertEquals($shop->name, 'Foo');
    }

    /** @test */
    public function it_can_delete_the_shop()
    {
        $this->actingAsAdmin();

        $shop = Shop::factory()->create();

        $shopsCount = Shop::count();

        $response = $this->delete(route('dashboard.shops.destroy', $shop));

        $response->assertRedirect();

        $this->assertEquals(Shop::count(), $shopsCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_shops()
    {
        if (! $this->useSoftDeletes($model = Shop::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Shop::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.shops.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_shop_details()
    {
        if (! $this->useSoftDeletes($model = Shop::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $shop = Shop::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.shops.trashed.show', $shop));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_shop()
    {
        if (! $this->useSoftDeletes($model = Shop::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $shop = Shop::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.shops.restore', $shop));

        $response->assertRedirect();

        $this->assertNull($shop->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_filter_shops_by_name()
    {
        $this->actingAsAdmin();

        Shop::factory()->create([
            'name' => 'Foo',
        ]);

        Shop::factory()->create([
            'name' => 'Bar',
        ]);

        $this->get(route('dashboard.shops.index', [
            'name' => 'Fo',
        ]))
            ->assertSuccessful()
            ->assertSee(trans('shops.filter'))
            ->assertSee('Foo')
            ->assertDontSee('Bar');
    }
}
