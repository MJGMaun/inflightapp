<?php

use Faker\Generator as Faker;

$factory->define(App\Artist::class, function (Faker $faker) {
    return [
       'artist_name' => $faker->name,
    ];
});
