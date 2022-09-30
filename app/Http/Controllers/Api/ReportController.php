<?php

namespace App\Http\Controllers\Api;

use App\Models\Report;
use Illuminate\Routing\Controller;
use App\Http\Resources\ReportResource;
use App\Http\Resources\SelectResource;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Display a listing of the reports.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $reports = Report::filter()->simplePaginate();

        return ReportResource::collection($reports);
    }

    /**
     * Display the specified report.
     *
     * @param \App\Models\Report $report
     * @return \App\Http\Resources\ReportResource
     */
    public function show(Report $report)
    {
        return new ReportResource($report);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function select()
    {
        $reports = Report::filter()->simplePaginate();

        return SelectResource::collection($reports);
    }
}
