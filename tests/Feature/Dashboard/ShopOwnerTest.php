<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\ShopOwner;

class ShopOwnerTest extends TestCase
{
    /** @test */
    public function it_can_display_list_of_shop_owners()
    {
        $this->actingAsAdmin();

        ShopOwner::factory()->create(['name' => 'Ahmed']);

        $response = $this->get(route('dashboard.shop_owners.index'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_shop_owner_details()
    {
        $this->actingAsAdmin();

        $shop_owner = ShopOwner::factory()->create(['name' => 'Ahmed']);

        $response = $this->get(route('dashboard.shop_owners.show', $shop_owner));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_shop_owner_create_form()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.shop_owners.create'));

        $response->assertSuccessful();

        $response->assertSee(trans('shop_owners.actions.create'));
    }

    /** @test */
    public function it_can_create_shop_owners()
    {
        $this->actingAsAdmin();

        $shop_ownersCount = ShopOwner::count();

        $response = $this->postJson(
            route('dashboard.shop_owners.store'),
            ShopOwner::factory()->raw([
                'name' => 'ShopOwner',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
        );

        $response->assertRedirect();

        $this->assertEquals(ShopOwner::count(), $shop_ownersCount + 1);
    }

    /** @test */
    public function it_can_display_shop_owner_edit_form()
    {
        $this->actingAsAdmin();

        $shop_owner = ShopOwner::factory()->create();

        $response = $this->get(route('dashboard.shop_owners.edit', $shop_owner));

        $response->assertSuccessful();

        $response->assertSee(trans('shop_owners.actions.edit'));
    }

    /** @test */
    public function it_can_update_shop_owners()
    {
        $this->actingAsAdmin();

        $shop_owner = ShopOwner::factory()->create();

        $response = $this->put(
            route('dashboard.shop_owners.update', $shop_owner),
            ShopOwner::factory()->raw([
                'name' => 'ShopOwner',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
        );

        $response->assertRedirect();

        $shop_owner->refresh();

        $this->assertEquals($shop_owner->name, 'ShopOwner');
    }

    /** @test */
    public function it_can_delete_shop_owner()
    {
        $this->actingAsAdmin();

        $shop_owner = ShopOwner::factory()->create();

        $shop_ownersCount = ShopOwner::count();

        $response = $this->delete(route('dashboard.shop_owners.destroy', $shop_owner));
        $response->assertRedirect();

        $this->assertEquals(ShopOwner::count(), $shop_ownersCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_shop_owners()
    {
        if (! $this->useSoftDeletes($model = ShopOwner::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        ShopOwner::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.shop_owners.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_shop_owner_details()
    {
        if (! $this->useSoftDeletes($model = ShopOwner::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $shop_owner = ShopOwner::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.shop_owners.trashed.show', $shop_owner));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_shop_owner()
    {
        if (! $this->useSoftDeletes($model = ShopOwner::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $shop_owner = ShopOwner::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.shop_owners.restore', $shop_owner));

        $response->assertRedirect();

        $this->assertNull($shop_owner->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_filter_shop_owners_by_name()
    {
        $this->actingAsAdmin();

        ShopOwner::factory()->create(['name' => 'Ahmed']);

        ShopOwner::factory()->create(['name' => 'Mohamed']);

        $this->get(route('dashboard.shop_owners.index', [
            'name' => 'ahmed',
        ]))
            ->assertSuccessful()
            ->assertSee('Ahmed')
            ->assertDontSee('Mohamed');
    }

    /** @test */
    public function it_can_filter_shop_owners_by_email()
    {
        $this->actingAsAdmin();

        ShopOwner::factory()->create([
            'name' => 'FooBar1',
            'email' => 'user1@demo.com',
        ]);

        ShopOwner::factory()->create([
            'name' => 'FooBar2',
            'email' => 'user2@demo.com',
        ]);

        $this->get(route('dashboard.shop_owners.index', [
            'email' => 'user1@',
        ]))
            ->assertSuccessful()
            ->assertSee('FooBar1')
            ->assertDontSee('FooBar2');
    }

    /** @test */
    public function it_can_filter_shop_owners_by_phone()
    {
        $this->actingAsAdmin();

        ShopOwner::factory()->create([
            'name' => 'FooBar1',
            'phone' => '123',
        ]);

        ShopOwner::factory()->create([
            'name' => 'FooBar2',
            'email' => '456',
        ]);

        $this->get(route('dashboard.shop_owners.index', [
            'phone' => '123',
        ]))
            ->assertSuccessful()
            ->assertSee('FooBar1')
            ->assertDontSee('FooBar2');
    }
}
