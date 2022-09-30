<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Astrotomic\Translatable\Validation\RuleFactory;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_a_list_of_categories()
    {
        $this->actingAsAdmin();

        Category::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.categories.index'))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_the_category_details()
    {
        $this->actingAsAdmin();

        $category = Category::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.categories.show', $category))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_categories_create_form()
    {
        $this->actingAsAdmin();

        $this->get(route('dashboard.categories.create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_a_new_category()
    {
        $this->actingAsAdmin();

        $categoriesCount = Category::count();

        $response = $this->post(
            route('dashboard.categories.store'),
            Category::factory()->raw(
                RuleFactory::make([
                    '%name%' => 'Foo',
                ])
            )
        );

        $response->assertRedirect();

        $category = Category::all()->last();

        $this->assertEquals(Category::count(), $categoriesCount + 1);

        $this->assertEquals($category->name, 'Foo');
    }

    /** @test */
    public function it_can_display_the_categories_edit_form()
    {
        $this->actingAsAdmin();

        $category = Category::factory()->create();

        $this->get(route('dashboard.categories.edit', $category))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_update_the_category()
    {
        $this->actingAsAdmin();

        $category = Category::factory()->create();

        $response = $this->put(
            route('dashboard.categories.update', $category),
            Category::factory()->raw(
                RuleFactory::make([
                    '%name%' => 'Foo',
                ])
            )
        );

        $category->refresh();

        $response->assertRedirect();

        $this->assertEquals($category->name, 'Foo');
    }

    /** @test */
    public function it_can_delete_the_category()
    {
        $this->actingAsAdmin();

        $category = Category::factory()->create();

        $categoriesCount = Category::count();

        $response = $this->delete(route('dashboard.categories.destroy', $category));

        $response->assertRedirect();

        $this->assertEquals(Category::count(), $categoriesCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_categories()
    {
        if (! $this->useSoftDeletes($model = Category::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Category::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.categories.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_category_details()
    {
        if (! $this->useSoftDeletes($model = Category::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $category = Category::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.categories.trashed.show', $category));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_category()
    {
        if (! $this->useSoftDeletes($model = Category::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $category = Category::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.categories.restore', $category));

        $response->assertRedirect();

        $this->assertNull($category->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_force_delete_category()
    {
        if (! $this->useSoftDeletes($model = Category::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $category = Category::factory()->create(['deleted_at' => now()]);

        $categoryCount = Category::withTrashed()->count();

        $this->actingAsAdmin();

        $response = $this->delete(route('dashboard.categories.forceDelete', $category));

        $response->assertRedirect();

        $this->assertEquals(Category::withoutTrashed()->count(), $categoryCount - 1);
    }

    /** @test */
    public function it_can_filter_categories_by_name()
    {
        $this->actingAsAdmin();

        Category::factory()->create([
            'name' => 'Foo',
        ]);

        Category::factory()->create([
            'name' => 'Bar',
        ]);

        $this->get(route('dashboard.categories.index', [
            'name' => 'Fo',
        ]))
            ->assertSuccessful()
            ->assertSee(trans('categories.filter'))
            ->assertSee('Foo')
            ->assertDontSee('Bar');
    }
}
