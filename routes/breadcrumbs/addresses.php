<?php

Breadcrumbs::for('dashboard.addresses.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('addresses.plural'), route('dashboard.addresses.index'));
});

Breadcrumbs::for('dashboard.addresses.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.addresses.index');
    $breadcrumb->push(trans('addresses.trashed'), route('dashboard.addresses.trashed'));
});

Breadcrumbs::for('dashboard.addresses.create', function ($breadcrumb,$item) {
    $breadcrumb->parent('dashboard.addresses.index');
    $breadcrumb->push($item->name, route('dashboard.addresses.create', $item));
});

Breadcrumbs::for('dashboard.addresses.show', function ($breadcrumb, $address) {
    $breadcrumb->parent('dashboard.addresses.index');
    $breadcrumb->push($address->name, route('dashboard.addresses.show', $address));
});

Breadcrumbs::for('dashboard.addresses.edit', function ($breadcrumb, $address) {
    $breadcrumb->parent('dashboard.addresses.show', $address);
    $breadcrumb->push(trans('addresses.actions.edit'), route('dashboard.addresses.edit', $address));
});
