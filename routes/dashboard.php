<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dashboard Routes
|--------------------------------------------------------------------------
|
| Here is where you can register dashboard routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "dashboard" middleware group and "App\Http\Controllers\Dashboard" namespace.
| and "dashboard." route's alias name. Enjoy building your dashboard!
|
*/
Route::get('locale/{locale}', 'LocaleController@update')->name('locale')->where('locale', '(ar|en)');

Route::get('/', 'DashboardController@index')->name('home');

// Select All Routes.
Route::delete('delete', 'DeleteController@destroy')->name('delete.selected');
Route::delete('forceDelete', 'DeleteController@forceDelete')->name('forceDelete.selected');
Route::delete('restore', 'DeleteController@restore')->name('restore.selected');

// Customers Routes.
Route::get('trashed/customers', 'CustomerController@trashed')->name('customers.trashed');
Route::get('trashed/customers/{trashed_customer}', 'CustomerController@showTrashed')->name('customers.trashed.show');
Route::post('customers/{trashed_customer}/restore', 'CustomerController@restore')->name('customers.restore');
Route::delete('customers/{trashed_customer}/forceDelete', 'CustomerController@forceDelete')->name('customers.forceDelete');
Route::resource('customers', 'CustomerController');
Route::get('customers/active/{id}', 'CustomerController@active')->name('customers.active');
Route::get('customers/disactive/{id}', 'CustomerController@disactive')->name('customers.disactive');
// Supervisors Routes.
Route::get('trashed/supervisors', 'SupervisorController@trashed')->name('supervisors.trashed');
Route::get('trashed/supervisors/{trashed_supervisor}', 'SupervisorController@showTrashed')->name('supervisors.trashed.show');
Route::post('supervisors/{trashed_supervisor}/restore', 'SupervisorController@restore')->name('supervisors.restore');
Route::delete('supervisors/{trashed_supervisor}/forceDelete', 'SupervisorController@forceDelete')->name('supervisors.forceDelete');
Route::resource('supervisors', 'SupervisorController');

// Shop Owner Routes.
Route::get('trashed/shop_owners', 'ShopOwnerController@trashed')->name('shop_owners.trashed');
Route::get('trashed/shop_owners/{trashed_shop_owner}', 'ShopOwnerController@showTrashed')->name('shop_owners.trashed.show');
Route::post('shop_owners/{trashed_shop_owner}/restore', 'ShopOwnerController@restore')->name('shop_owners.restore');
Route::delete('shop_owners/{trashed_shop_owner}/forceDelete', 'ShopOwnerController@forceDelete')->name('shop_owners.forceDelete');
Route::resource('shop_owners', 'ShopOwnerController');
Route::get('shop_owners/active/{id}', 'ShopOwnerController@active')->name('shop_owners.active');
Route::get('shop_owners/disactive/{id}', 'ShopOwnerController@disactive')->name('shop_owners.disactive');

// Delegate Routes.
Route::get('trashed/delegates', 'DelegateController@trashed')->name('delegates.trashed');
Route::get('trashed/delegates/{trashed_delegate}', 'DelegateController@showTrashed')->name('delegates.trashed.show');
Route::post('delegates/{trashed_delegate}/restore', 'DelegateController@restore')->name('delegates.restore');
Route::delete('delegates/{trashed_delegate}/forceDelete', 'DelegateController@forceDelete')->name('delegates.forceDelete');
Route::resource('delegates', 'DelegateController');
Route::get('delegates/active/{id}', 'DelegateController@active')->name('delegates.active');
Route::get('delegates/disactive/{id}', 'DelegateController@disactive')->name('delegates.disactive');
// Admins Routes.
Route::get('trashed/admins', 'AdminController@trashed')->name('admins.trashed');
Route::get('trashed/admins/{trashed_admin}', 'AdminController@showTrashed')->name('admins.trashed.show');
Route::post('admins/{trashed_admin}/restore', 'AdminController@restore')->name('admins.restore');
Route::delete('admins/{trashed_admin}/forceDelete', 'AdminController@forceDelete')->name('admins.forceDelete');
Route::resource('admins', 'AdminController');

// Settings Routes.
Route::get('settings', 'SettingController@index')->name('settings.index');
Route::patch('settings', 'SettingController@update')->name('settings.update');
Route::get('backup/download', 'SettingController@downloadBackup')->name('backup.download');

// Feedback Routes.
Route::get('trashed/feedback', 'FeedbackController@trashed')->name('feedback.trashed');
Route::get('trashed/feedback/{trashed_feedback}', 'FeedbackController@showTrashed')->name('feedback.trashed.show');
Route::post('feedback/{trashed_feedback}/restore', 'FeedbackController@restore')->name('feedback.restore');
Route::delete('feedback/{trashed_feedback}/forceDelete', 'FeedbackController@forceDelete')->name('feedback.forceDelete');
Route::patch('feedback/read', 'FeedbackController@read')->name('feedback.read');
Route::patch('feedback/unread', 'FeedbackController@unread')->name('feedback.unread');
Route::resource('feedback', 'FeedbackController')->only('index', 'show', 'destroy');

// Cities Routes.
Route::get('trashed/cities', 'CityController@trashed')->name('cities.trashed');
Route::get('trashed/cities/{trashed_city}', 'CityController@showTrashed')->name('cities.trashed.show');
Route::post('cities/{trashed_city}/restore', 'CityController@restore')->name('cities.restore');
Route::delete('cities/{trashed_city}/forceDelete', 'CityController@forceDelete')->name('cities.forceDelete');
Route::resource('cities', 'CityController');
Route::get('fcm/{id}', 'CityController@fcm');
Route::get('cities/active/{id}', 'CityController@active')->name('cities.active');
Route::get('cities/disactive/{id}', 'CityController@disactive')->name('cities.disactive');

// Shops Routes.
Route::get('trashed/shops', 'ShopController@trashed')->name('shops.trashed');
Route::get('trashed/shops/{trashed_shop}', 'ShopController@showTrashed')->name('shops.trashed.show');
Route::post('shops/{trashed_shop}/restore', 'ShopController@restore')->name('shops.restore');
Route::delete('shops/{trashed_shop}/forceDelete', 'ShopController@forceDelete')->name('shops.forceDelete');
Route::resource('shops', 'ShopController')->except(['create']);
Route::get('create/shops/{id}', 'ShopController@create')->name('shops.create');



// Categories Routes.
Route::get('trashed/categories', 'CategoryController@trashed')->name('categories.trashed');
Route::get('trashed/categories/{trashed_category}', 'CategoryController@showTrashed')->name('categories.trashed.show');
Route::post('categories/{trashed_category}/restore', 'CategoryController@restore')->name('categories.restore');
Route::delete('categories/{trashed_category}/forceDelete', 'CategoryController@forceDelete')->name('categories.forceDelete');
Route::resource('categories', 'CategoryController');

// Products Routes.
Route::get('trashed/products', 'ProductController@trashed')->name('products.trashed');
Route::get('trashed/products/{trashed_product}', 'ProductController@showTrashed')->name('products.trashed.show');
Route::post('products/{trashed_product}/restore', 'ProductController@restore')->name('products.restore');
Route::delete('products/{trashed_product}/forceDelete', 'ProductController@forceDelete')->name('products.forceDelete');
Route::get('products/{product}/lock', 'ProductController@toggleLock')->name('products.lock');
Route::resource('products', 'ProductController');

// Orders Routes.
Route::get('trashed/orders', 'OrderController@trashed')->name('orders.trashed');
Route::get('trashed/orders/{trashed_order}', 'OrderController@showTrashed')->name('orders.trashed.show');
Route::post('orders/{trashed_order}/restore', 'OrderController@restore')->name('orders.restore');
Route::delete('orders/{trashed_order}/forceDelete', 'OrderController@forceDelete')->name('orders.forceDelete');
Route::resource('orders', 'OrderController');
Route::post('shop_orders/{shop_order}/delegate', 'OrderController@assignDelegate')->name('shop_orders.assign-delegate');

// Addresses Routes.
Route::get('trashed/addresses', 'AddressController@trashed')->name('addresses.trashed');
Route::get('trashed/addresses/{trashed_address}', 'AddressController@showTrashed')->name('addresses.trashed.show');
Route::post('addresses/{trashed_address}/restore', 'AddressController@restore')->name('addresses.restore');
Route::delete('addresses/{trashed_address}/forceDelete', 'AddressController@forceDelete')->name('addresses.forceDelete');
Route::resource('addresses', 'AddressController')->except(['create']);
Route::get('create/addresses/{id}', 'AddressController@create')->name('addresses.create');


// Reports Routes.
Route::get('trashed/reports', 'ReportController@trashed')->name('reports.trashed');
Route::get('trashed/reports/{trashed_report}', 'ReportController@showTrashed')->name('reports.trashed.show');
Route::post('reports/{trashed_report}/restore', 'ReportController@restore')->name('reports.restore');
Route::delete('reports/{trashed_report}/forceDelete', 'ReportController@forceDelete')->name('reports.forceDelete');
Route::patch('reports/read', 'ReportController@read')->name('reports.read');
Route::patch('reports/unread', 'ReportController@unread')->name('reports.unread');
Route::resource('reports', 'ReportController');

// Coupons Routes.
Route::get('trashed/coupons', 'CouponController@trashed')->name('coupons.trashed');
Route::get('trashed/coupons/{trashed_coupon}', 'CouponController@showTrashed')->name('coupons.trashed.show');
Route::post('coupons/{trashed_coupon}/restore', 'CouponController@restore')->name('coupons.restore');
Route::delete('coupons/{trashed_coupon}/forceDelete', 'CouponController@forceDelete')->name('coupons.forceDelete');
Route::resource('coupons', 'CouponController');
Route::get('delegates/{delegate}/collect', 'DelegateController@collect')->name('delegates.collect');
Route::get('shops/{shop}/collect', 'ShopController@collect')->name('shops.collect');

/*  The routes of generated crud will set here: Don't remove this line  */
Route::resource('notifications', 'NotificationController');
Route::get('notification/certain', 'NotificationController@certain')->name('notifications.certain');
