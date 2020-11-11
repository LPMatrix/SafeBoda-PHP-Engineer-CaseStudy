<?php
// namespace App\Coupon;

use Faker\Generator as Faker;
use App\Coupon;

$factory->define(Coupon::class, function (Faker $faker) {
    return [
        'event_id' => $faker->numberBetween(1, 2),
        'radius' => $faker->numberBetween(10, 100),
        'expires_at' => $faker->date,
        'active' => 1,
        'used' => 0,
        'amount' => $faker->numberBetween(200, 10000),
    ];
});