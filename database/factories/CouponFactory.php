<?php
// namespace App\Coupon;

use Faker\Generator as Faker;
use App\Coupon;
use App\Http\Classes\CouponCode;

$factory->define(Coupon::class, function (Faker $faker) {
    return [
    	'code' => (new CouponCode)->generateCouponString(6),
        'event_id' => $faker->numberBetween(1, 2),
        'radius' => $faker->numberBetween(10, 100),
        'expires_at' => $faker->date,
        'active' => '1',
        'used' => '0',
        'amount' => $faker->numberBetween(200, 10000),
    ];
});