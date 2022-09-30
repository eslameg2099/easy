<?php

Breadcrumbs::for('dashboard.delegates.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('delegates.plural'), route('dashboard.delegates.index'));
});

Breadcrumbs::for('dashboard.delegates.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.delegates.index');
    $breadcrumb->push(trans('delegates.trashed'), route('dashboard.delegates.trashed'));
});

Breadcrumbs::for('dashboard.delegates.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.delegates.index');
    $breadcrumb->push(trans('delegates.actions.create'), route('dashboard.delegates.create'));
});

Breadcrumbs::for('dashboard.delegates.show', function ($breadcrumb, $delegate) {
    $breadcrumb->parent('dashboard.delegates.index');
    $breadcrumb->push($delegate->name, route('dashboard.delegates.show', $delegate));
});

Breadcrumbs::for('dashboard.delegates.edit', function ($breadcrumb, $delegate) {
    $breadcrumb->parent('dashboard.delegates.show', $delegate);
    $breadcrumb->push(trans('delegates.actions.edit'), route('dashboard.delegates.edit', $delegate));
});
