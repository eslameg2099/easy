<?php

Breadcrumbs::for('dashboard.reports.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('reports.plural'), route('dashboard.reports.index'));
});

Breadcrumbs::for('dashboard.reports.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.reports.index');
    $breadcrumb->push(trans('reports.trashed'), route('dashboard.reports.trashed'));
});

Breadcrumbs::for('dashboard.reports.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.reports.index');
    $breadcrumb->push(trans('reports.actions.create'), route('dashboard.reports.create'));
});

Breadcrumbs::for('dashboard.reports.show', function ($breadcrumb, $report) {
    $breadcrumb->parent('dashboard.reports.index');
    $breadcrumb->push('#'.$report->id, route('dashboard.reports.show', $report));
});

Breadcrumbs::for('dashboard.reports.edit', function ($breadcrumb, $report) {
    $breadcrumb->parent('dashboard.reports.show', $report);
    $breadcrumb->push(trans('reports.actions.edit'), route('dashboard.reports.edit', $report));
});
