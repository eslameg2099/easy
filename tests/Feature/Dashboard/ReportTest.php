<?php

namespace Tests\Feature\Dashboard;

use Tests\TestCase;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_display_a_list_of_reports()
    {
        $this->actingAsAdmin();

        Report::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.reports.index'))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_the_report_details()
    {
        $this->actingAsAdmin();

        $report = Report::factory()->create(['name' => 'Foo']);

        $this->get(route('dashboard.reports.show', $report))
            ->assertSuccessful()
            ->assertSee('Foo');
    }

    /** @test */
    public function it_can_display_reports_create_form()
    {
        $this->actingAsAdmin();

        $this->get(route('dashboard.reports.create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_a_new_report()
    {
        $this->actingAsAdmin();

        $reportsCount = Report::count();

        $response = $this->post(
            route('dashboard.reports.store'),
            Report::factory()->raw([
                'name' => 'Foo',
            ])
        );

        $response->assertRedirect();

        $report = Report::all()->last();

        $this->assertEquals(Report::count(), $reportsCount + 1);

        $this->assertEquals($report->name, 'Foo');
    }

    /** @test */
    public function it_can_display_the_reports_edit_form()
    {
        $this->actingAsAdmin();

        $report = Report::factory()->create();

        $this->get(route('dashboard.reports.edit', $report))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_update_the_report()
    {
        $this->actingAsAdmin();

        $report = Report::factory()->create();

        $response = $this->put(
            route('dashboard.reports.update', $report),
            Report::factory()->raw([
                'name' => 'Foo',
            ])
        );

        $report->refresh();

        $response->assertRedirect();

        $this->assertEquals($report->name, 'Foo');
    }

    /** @test */
    public function it_can_delete_the_report()
    {
        $this->actingAsAdmin();

        $report = Report::factory()->create();

        $reportsCount = Report::count();

        $response = $this->delete(route('dashboard.reports.destroy', $report));

        $response->assertRedirect();

        $this->assertEquals(Report::count(), $reportsCount - 1);
    }

    /** @test */
    public function it_can_display_trashed_reports()
    {
        if (! $this->useSoftDeletes($model = Report::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        Report::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.reports.trashed'));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_display_trashed_report_details()
    {
        if (! $this->useSoftDeletes($model = Report::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $report = Report::factory()->create(['deleted_at' => now(), 'name' => 'Ahmed']);

        $this->actingAsAdmin();

        $response = $this->get(route('dashboard.reports.trashed.show', $report));

        $response->assertSuccessful();

        $response->assertSee('Ahmed');
    }

    /** @test */
    public function it_can_restore_deleted_report()
    {
        if (! $this->useSoftDeletes($model = Report::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $report = Report::factory()->create(['deleted_at' => now()]);

        $this->actingAsAdmin();

        $response = $this->post(route('dashboard.reports.restore', $report));

        $response->assertRedirect();

        $this->assertNull($report->refresh()->deleted_at);
    }

    /** @test */
    public function it_can_force_delete_report()
    {
        if (! $this->useSoftDeletes($model = Report::class)) {
            $this->markTestSkipped("The '$model' doesn't use soft deletes trait.");
        }

        $report = Report::factory()->create(['deleted_at' => now()]);

        $reportCount = Report::withTrashed()->count();

        $this->actingAsAdmin();

        $response = $this->delete(route('dashboard.reports.forceDelete', $report));

        $response->assertRedirect();

        $this->assertEquals(Report::withoutTrashed()->count(), $reportCount - 1);
    }

    /** @test */
    public function it_can_filter_reports_by_name()
    {
        $this->actingAsAdmin();

        Report::factory()->create([
            'name' => 'Foo',
        ]);

        Report::factory()->create([
            'name' => 'Bar',
        ]);

        $this->get(route('dashboard.reports.index', [
            'name' => 'Fo',
        ]))
            ->assertSuccessful()
            ->assertSee(trans('reports.filter'))
            ->assertSee('Foo')
            ->assertDontSee('Bar');
    }
}
