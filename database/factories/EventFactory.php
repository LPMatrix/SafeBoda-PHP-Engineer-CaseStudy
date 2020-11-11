<?php
// namespace App\Coupon;

use Faker\Generator as Faker;
use App\Event;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'name' => $faker->catchPhrase,
        'longitude' => $faker->longitude(),
        'latitude' => $faker->latitude(),
    ];
});