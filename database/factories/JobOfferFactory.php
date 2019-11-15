<?php

/** @var Factory $factory */

use App\Models\JobOffer;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;

$factory->define(JobOffer::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text,
        'email' => $faker->safeEmail,
        'state' => $faker->randomElement(['published', 'spam', null]),
        'valid_until' => now()->addDays(rand(1, 5)),
        'user_id' => $faker->numberBetween(1, 10)
    ];
});
