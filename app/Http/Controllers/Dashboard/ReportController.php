<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Requests\Dashboard\ReportRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReportController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * ReportController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Report::class, 'report');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::filter()->latest()->paginate();

        return view('dashboard.reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.reports.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ReportRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ReportRequest $request)
    {
        $report = Report::create($request->all());

        flash()->success(trans('reports.messages.created'));

        return redirect()->route('dashboard.reports.show', $report);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        $report->markAsRead();

        return view('dashboard.reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        return view('dashboard.reports.edit', compact('report'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\Dashboard\ReportRequest $request
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ReportRequest $request, Report $report)
    {
        $report->update($request->all());

        flash()->success(trans('reports.messages.updated'));

        return redirect()->route('dashboard.reports.show', $report);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Report $report
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Report $report)
    {
        $report->delete();

        flash()->success(trans('reports.messages.deleted'));

        return redirect()->route('dashboard.reports.index');
    }

    /**
     * Display a listing of the trashed resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $this->authorize('viewAnyTrash', Report::class);

        $reports = Report::onlyTrashed()->paginate();

        return view('dashboard.reports.trashed', compact('reports'));
    }

    /**
     * Display the specified trashed resource.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\Response
     */
    public function showTrashed(Report $report)
    {
        $this->authorize('viewTrash', $report);

        return view('dashboard.reports.show', compact('report'));
    }

    /**
     * Restore the trashed resource.
     *
     * @param \App\Models\Report $report
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Report $report)
    {
        $this->authorize('restore', $report);

        $report->restore();

        flash()->success(trans('reports.messages.restored'));

        return redirect()->route('dashboard.reports.trashed');
    }

    /**
     * Force delete the specified resource from storage.
     *
     * @param \App\Models\Report $report
     * @throws \Exception
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete(Report $report)
    {
        $this->authorize('forceDelete', $report);

        $report->forceDelete();

        flash()->success(trans('reports.messages.deleted'));

        return redirect()->route('dashboard.reports.trashed');
    }

    /**
     * Mark the selected messages as read.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function read(Request $request)
    {
        Report::query()
            ->whereIn('id', $request->input('items', []))
            ->update(['read_at' => now()]);

        return redirect()->route('dashboard.reports.index');
    }

    /**
     * Mark the selected messages as unread.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unread(Request $request)
    {
        Report::query()
            ->whereIn('id', $request->input('items', []))
            ->update(['read_at' => null]);

        return redirect()->route('dashboard.reports.index');
    }
}
