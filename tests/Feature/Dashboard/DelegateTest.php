<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Delegate;

class DelegateTest extends TestCase
{
    /** @test */
    public function it_can_display_list_of_delegates()
    {
        $this->actingAsAdmin();

        Delegate::factory()->create(['name' => 'Ahmed']);

        $response = $this->get(route('dashboard.delegates.index'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_delegate_details()
    {
        $this->actingAsAdmin();

        $delegate = Delegate::factory()->create(['name' => 'Ahmed']);

        $response = $this->get(route('dashboard.delegates.show', $delegate));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_delegate_create_form()
    {
        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.delegates.create'));

        $response->assertSuccessful();

        $response->assertSee(trans('delegates.actions.create'));
    }

    /** @test */
    public function it_can_create_delegates()
    {
        $this->actingAsAdmin();

        $delegatesCount = Delegate::count();

        $response = $this->postJson(
            route('dashboard.delegates.store'),
            Delegate::factory()->raw([
                'name' => 'Delegate',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
        );

        $response->assertRedirect();

        $this->assertEquals(Delegate::count(), $delegatesCount + 1);
    }

    /** @test */
    public function it_can_display_delegate_edit_form()
    {
        $this->actingAsAdmin();

        $delegate = Delegate::factory()->create();

        $response = $this->get(route('dashboard.delegates.edit', $delegate));

        $response->assertSuccessful();

        $response->assertSee(trans('delegates.actions.edit'));
    }

    /** @test */
    public function it_can_update_delegates()
    {
        $this->actingAsAdmin();

        $delegate = Delegate::factory()->create();

        $response = $this->put(
            route('dashboard.delegates.update', $delegate),
            Delegate::factory()->raw([
                'name' => 'Delegate',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
        );

        $response->assertRedirect();

        $delegate->refresh();

        $this->assertEquals($delegate->name, 'Delegate');
    }

    /** @test */
    public function it_can_delete_delegate()
    {
        $this->actingAsAdmin();

        $delegate = Delegate::factory()->create();

        $delegatesCount = Delegate::count();

        $response = $this->delete(route('dashboard.delegates.destroy', $delegate));
        $response->assertRedirect();

        $this->assertEquals(Delegate::count(), $delegatesCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_delegates()
    {
        if (! $this->useSoftDeletes($model = Delegate::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Delegate::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.delegates.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_delegate_details()
    {
        if (! $this->useSoftDeletes($model = Delegate::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $delegate = Delegate::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.delegates.trashed.show', $delegate));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_delegate()
    {
        if (! $this->useSoftDeletes($model = Delegate::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $delegate = Delegate::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.delegates.restore', $delegate));

        $response->assertRedirect();

        $this->assertNull($delegate->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_filter_delegates_by_name()
    {
        $this->actingAsAdmin();

        Delegate::factory()->create(['name' => 'Ahmed']);

        Delegate::factory()->create(['name' => 'Mohamed']);

        $this->get(route('dashboard.delegates.index', [
            'name' => 'ahmed',
        ]))
            ->assertSuccessful()
            ->assertSee('Ahmed')
            ->assertDontSee('Mohamed');
    }

    /** @test */
    public function it_can_filter_delegates_by_email()
    {
        $this->actingAsAdmin();

        Delegate::factory()->create([
            'name' => 'FooBar1',
            'email' => 'user1@demo.com',
        ]);

        Delegate::factory()->create([
            'name' => 'FooBar2',
            'email' => 'user2@demo.com',
        ]);

        $this->get(route('dashboard.delegates.index', [
            'email' => 'user1@',
        ]))
            ->assertSuccessful()
            ->assertSee('FooBar1')
            ->assertDontSee('FooBar2');
    }

    /** @test */
    public function it_can_filter_delegates_by_phone()
    {
        $this->actingAsAdmin();

        Delegate::factory()->create([
            'name' => 'FooBar1',
            'phone' => '123',
        ]);

        Delegate::factory()->create([
            'name' => 'FooBar2',
            'email' => '456',
        ]);

        $this->get(route('dashboard.delegates.index', [
            'phone' => '123',
        ]))
            ->assertSuccessful()
            ->assertSee('FooBar1')
            ->assertDontSee('FooBar2');
    }
}
