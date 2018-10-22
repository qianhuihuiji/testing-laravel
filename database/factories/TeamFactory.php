<?php

use Faker\Generator as Faker;


$factory->define(App\Team::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'size' => 5
    ];
});
