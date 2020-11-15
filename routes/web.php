<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use Illuminate\Support\Str;

$router->get('/', function () use ($router) {
	    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {

	$router->get('/key', function(){
		return Str::random(32);;
	});

	$router->post('event/create_event', 'EventController@store');
	$router->get('event/events', 'EventController@index');

	$router->post('coupon/generate_coupon', 'CouponController@store');
	$router->get('coupon/coupons', 'CouponController@index');
	$router->get('coupon/active_coupons', 'CouponController@active_coupons');
	$router->put('coupon/update_coupon/{coupon}', 'CouponController@update');
	$router->put('coupon/deactivate_coupon/{coupon}', 'CouponController@deactivate_coupon');
	$router->post('coupon/validate', 'CouponController@verify');

});