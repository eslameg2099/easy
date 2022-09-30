<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Address;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_a_list_of_addresses()
    {
        $this->actingAsAdmin();

        Address::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.addresses.index'))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_the_address_details()
    {
        $this->actingAsAdmin();

        $address = Address::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.addresses.show', $address))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_addresses_create_form()
    {
        $this->actingAsAdmin();

        $this->get(route('dashboard.addresses.create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_a_new_address()
    {
        $this->actingAsAdmin();

        $addressesCount = Address::count();

        $response = $this->post(
            route('dashboard.addresses.store'),
            Address::factory()->raw([
                'name' => 'Foo',
            ])
        );

        $response->assertRedirect();

        $address = Address::all()->last();

        $this->assertEquals(Address::count(), $addressesCount + 1);

        $this->assertEquals($address->name, 'Foo');
    }

    /** @test */
    public function it_can_display_the_addresses_edit_form()
    {
        $this->actingAsAdmin();

        $address = Address::factory()->create();

        $this->get(route('dashboard.addresses.edit', $address))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_update_the_address()
    {
        $this->actingAsAdmin();

        $address = Address::factory()->create();

        $response = $this->put(
            route('dashboard.addresses.update', $address),
            Address::factory()->raw([
                'name' => 'Foo',
            ])
        );

        $address->refresh();

        $response->assertRedirect();

        $this->assertEquals($address->name, 'Foo');
    }

    /** @test */
    public function it_can_delete_the_address()
    {
        $this->actingAsAdmin();

        $address = Address::factory()->create();

        $addressesCount = Address::count();

        $response = $this->delete(route('dashboard.addresses.destroy', $address));

        $response->assertRedirect();

        $this->assertEquals(Address::count(), $addressesCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_addresses()
    {
        if (! $this->useSoftDeletes($model = Address::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Address::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.addresses.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_address_details()
    {
        if (! $this->useSoftDeletes($model = Address::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $address = Address::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.addresses.trashed.show', $address));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_address()
    {
        if (! $this->useSoftDeletes($model = Address::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $address = Address::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.addresses.restore', $address));

        $response->assertRedirect();

        $this->assertNull($address->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_force_delete_address()
    {
        if (! $this->useSoftDeletes($model = Address::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $address = Address::factory()->create(['deleted_at' => now()]);

        $addressCount = Address::withTrashed()->count();

        $this->actingAsAdmin();

        $response = $this->delete(route('dashboard.addresses.forceDelete', $address));

        $response->assertRedirect();

        $this->assertEquals(Address::withoutTrashed()->count(), $addressCount - 1);
    }

    /** @test */
    public function it_can_filter_addresses_by_name()
    {
        $this->actingAsAdmin();

        Address::factory()->create([
            'name' => 'Foo',
        ]);

        Address::factory()->create([
            'name' => 'Bar',
        ]);

        $this->get(route('dashboard.addresses.index', [
            'name' => 'Fo',
        ]))
            ->assertSuccessful()
            ->assertSee(trans('addresses.filter'))
            ->assertSee('Foo')
            ->assertDontSee('Bar');
    }
}
