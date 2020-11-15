<?php
use Faker\Generator as Faker;
use App\Coupon;
use Carbon\Carbon;


$factory->define(Coupon::class, function (Faker $faker) {
    return [
    	'code' => (new Coupon)->generateCouponString(6),
        'event_id' => $faker->numberBetween(1, 2),
        'radius' => $faker->numberBetween(100, 2000),
        'expires_at' => Carbon::now()->addDays(2)->toDateTimeString(),
        'amount' => $faker->numberBetween(200, 10000),
    ];
});