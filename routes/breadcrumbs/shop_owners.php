<?php

Breadcrumbs::for('dashboard.shop_owners.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('shop_owners.plural'), route('dashboard.shop_owners.index'));
});

Breadcrumbs::for('dashboard.shop_owners.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.shop_owners.index');
    $breadcrumb->push(trans('shop_owners.trashed'), route('dashboard.shop_owners.trashed'));
});

Breadcrumbs::for('dashboard.shop_owners.create', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.shop_owners.index');
    $breadcrumb->push(trans('shop_owners.actions.create'), route('dashboard.shop_owners.create'));
});

Breadcrumbs::for('dashboard.shop_owners.show', function ($breadcrumb, $shop_owner) {
    $breadcrumb->parent('dashboard.shop_owners.index');
    $breadcrumb->push($shop_owner->name, route('dashboard.shop_owners.show', $shop_owner));
});

Breadcrumbs::for('dashboard.shop_owners.edit', function ($breadcrumb, $shop_owner) {
    $breadcrumb->parent('dashboard.shop_owners.show', $shop_owner);
    $breadcrumb->push(trans('shop_owners.actions.edit'), route('dashboard.shop_owners.edit', $shop_owner));
});
