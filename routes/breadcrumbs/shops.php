<?php

Breadcrumbs::for('dashboard.shops.index', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.home');
    $breadcrumb->push(trans('shops.plural'), route('dashboard.shops.index'));
});

Breadcrumbs::for('dashboard.shops.trashed', function ($breadcrumb) {
    $breadcrumb->parent('dashboard.shops.index');
    $breadcrumb->push(trans('shops.trashed'), route('dashboard.shops.trashed'));
});



Breadcrumbs::for('dashboard.shops.create', function ($breadcrumb,$item) {
    $breadcrumb->parent('dashboard.shops.index');
    $breadcrumb->push($item->name, route('dashboard.shops.create',$item));
});

Breadcrumbs::for('dashboard.shops.show', function ($breadcrumb, $shop) {
    $breadcrumb->parent('dashboard.shops.index');
    $breadcrumb->push($shop->name, route('dashboard.shops.show', $shop));
});

Breadcrumbs::for('dashboard.shops.edit', function ($breadcrumb, $shop) {
    $breadcrumb->parent('dashboard.shops.show', $shop);
    $breadcrumb->push(trans('shops.actions.edit'), route('dashboard.shops.edit', $shop));
});
