<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\Report;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReportTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_reports()
    {
        $this->actingAsAdmin();

        Report::factory()->count(2)->create();

        $this->getJson(route('api.reports.index'))
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
    public function test_reports_select2_api()
    {
        Report::factory()->count(5)->create();

        $response = $this->getJson(route('api.reports.select'))
            ->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'text'],
                ],
            ]);

        $this->assertEquals($response->json('data.0.id'), 1);

        $this->assertCount(5, $response->json('data'));

        $response = $this->getJson(route('api.reports.select', ['selected_id' => 4]))
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
    public function it_can_display_the_report_details()
    {
        $this->actingAsAdmin();

        $report = Report::factory(['name' => 'Foo'])->create();

        $response = $this->getJson(route('api.reports.show', $report))
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
