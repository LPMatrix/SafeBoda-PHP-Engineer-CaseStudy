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

	$router->post('create_event', 'EventController@store');
	$router->get('events', 'EventController@index');

	$router->post('generate_coupon', 'CouponController@store');
	$router->get('coupons', 'CouponController@index');
	$router->get('active_coupons', 'CouponController@active_coupons');
	$router->post('update_coupon', 'CouponController@update');
	$router->put('use_coupon/{coupon}', 'CouponController@use');
	$router->put('deactivate_coupon/{coupon}', 'CouponController@deactivate_coupon');

	$router->get('new_coupon/{event}', 'CouponController@new_coupon');

});