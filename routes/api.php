<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group and "App\Http\Controllers\Api" namespace.
| and "api." route's alias name. Enjoy building your API!
|
*/
Route::post('/register', 'RegisterController@register')->name('sanctum.register');
Route::post('/login', 'LoginController@login')->name('sanctum.login');
Route::post('/firebase/login', 'LoginController@firebase')->name('sanctum.login.firebase');

Route::patch('delegates/{delegate}/approve', 'UserController@approve')->name('users.approve');

Route::post('/password/forget', 'ResetPasswordController@forget')->name('password.forget');
Route::post('/password/code', 'ResetPasswordController@code')->name('password.code');
Route::post('/password/reset', 'ResetPasswordController@reset')->name('password.reset');
Route::get('/select/users', 'UserController@select')->name('users.select');
Route::get('/selectdelegate/users/{id}', 'UserController@selectdelegate')->name('selectdelegate.select');



Route::middleware('auth:sanctum')->group(function () {
    Route::get('getPusherNotificationToken', 'LoginController@getPusherNotificationToken');

    Route::post('password', 'VerificationController@password')->name('password.check');
    Route::post('verification/send', 'VerificationController@send')->name('verification.send');
    Route::post('verification/verify', 'VerificationController@verify')->name('verification.verify');
    Route::get('profile', 'ProfileController@show')->name('profile.show');
    Route::get('profile/shop', 'ProfileController@shop')->name('profile.shop');
    Route::match(['put', 'patch'], 'profile', 'ProfileController@update')->name('profile.update');
});
Route::get('profile/shop/{shop}', 'ProfileController@shop')->name('profile.shop.show');
Route::post('/editor/upload', 'MediaController@editorUpload')->name('editor.upload');
Route::get('/settings', 'SettingController@index')->name('settings.index');
Route::get('/settings/pages/{page}', 'SettingController@page')->name('settings.page');

Route::post('feedback', 'FeedbackController@store')->name('feedback.send');
// Cities Routes.
Route::apiResource('cities', 'CityController');
Route::get('/select/cities', 'CityController@select')->name('cities.select');
Route::get('/select/cities/{city}', 'CityController@selectShow')->name('cities.selectShow');

// Shops Routes.
Route::apiResource('shops', 'ShopController');
Route::get('/select/shops', 'ShopController@select')->name('shops.select');

// Categories Routes.
Route::apiResource('categories', 'CategoryController');
Route::get('/select2/categories', 'CategoryController@select2')->name('categories.select2');
Route::get('/select/categories', 'CategoryController@select')->name('categories.select');
Route::get('/select/categories/{category}', 'CategoryController@selectShow')->name('categories.selectShow');

// Products Routes.
Route::get('products/{product}/reviews', 'ProductController@reviews')->name('products.reviews');
Route::post('products/{product}/review', 'ProductController@review')->name('products.review');
Route::patch('products/{product}/lock', 'ProductController@toggleLock')->name('products.lock');
Route::get('my/products', 'ProductController@myProducts')->name('my.products');
Route::apiResource('products', 'ProductController');
Route::get('/select/products', 'ProductController@select')->name('products.select');

// Orders Routes.
Route::patch('shop/orders/{shop_order}/accept', 'ShopOrderController@accept')->name('shop_orders.accept');
Route::patch('shop/orders/{shop_order}/waiting-deliver', 'ShopOrderController@markAsWaitingDeliver')->name('shop_orders.waiting-deliver');
Route::patch('orders/{shop_order}/assigned-to-delegate', 'ShopOrderController@markAsAssignedToDelegate')->name('shop_orders.assigned-to-delegate');
Route::patch('orders/{shop_order}/delivering-to-delegate', 'ShopOrderController@markAsDeliveringToDelegate')->name('shop_orders.delivering-to-delegate');
Route::patch('shop/orders/{shop_order}/delivered-to-delegate', 'ShopOrderController@markAsDeliveredToDelegate')->name('shop_orders.delivered-to-delegate');
Route::patch('orders/{shop_order}/delivering', 'ShopOrderController@markAsDelivering')->name('shop_orders.delivering');
Route::patch('orders/{shop_order}/delivered', 'ShopOrderController@markAsDelivered')->name('shop_orders.delivered');
Route::post('orders/{shop_order}/report', 'ShopOrderController@report')->name('shop_orders.report');
Route::apiResource('orders', 'OrderController');
Route::get('shop/orders', 'ShopOrderController@index')->name('shop_orders.index');
Route::post('shop/collect', 'ShopOrderController@collect')->name('shop_orders.collect');
Route::post('delegate/collect', 'ShopOrderController@delegateCollect')->name('shop_orders.delegate-collect');
Route::get('shop/balance', 'ShopOrderController@getBalance')->name('shop_orders.balance');
Route::get('delegate/balance', 'ShopOrderController@getDelegateBalance')->name('shop_orders.delegate-balance');
Route::get('shop/orders/{shop_order}', 'ShopOrderController@show')->name('shop_orders.show');

// Addresses Routes.
Route::apiResource('addresses', 'AddressController');
Route::get('/select/addresses', 'AddressController@select')->name('addresses.select');

// Reports Routes.
Route::apiResource('reports', 'ReportController');
Route::get('/select/reports', 'ReportController@select')->name('reports.select');


Route::get('/user/home', 'HomeController')->name('user.home');
Route::post('/products/{product}/favorite', 'ProductController@favorite')->name('products.favorite');
Route::get('/favorite', 'ProductController@getFavorite')->name('favorite');

Route::patch('/location', 'ProfileController@updateLocation')->name('location.update')->middleware('auth:sanctum', 'user:delegate');

Route::get('/delegates/{delegate}/location', 'ProfileController@getLocation')->name('location.get')->middleware('auth:sanctum', 'user:customer');


Route::get('/cart', 'CartController@get')->name('cart.show');
Route::post('/cart', 'CartController@addItem')->name('cart.add');
Route::patch('/cart', 'CartController@update')->name('cart.update');
Route::patch('/cart/{cart_item}', 'CartController@updateItem')->name('cart.update-item');
Route::delete('/cart/{cart_item}', 'CartController@deleteItem')->name('cart.delete-item');
//reorder
Route::post('/reorder', 'CartController@reorder');



// Coupons Routes.
Route::apiResource('coupons', 'CouponController');
Route::get('/select/coupons', 'CouponController@select')->name('coupons.select');

/*  The routes of generated crud will set here: Don't remove this line  */
