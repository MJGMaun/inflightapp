<?php

use Faker\Generator as Faker;
use App\Artist;
use App\Album;

$factory->define(App\Album::class, function (Faker $faker) {
    return [
        'album_name' => $faker->word,
        'cover_image' => $faker->imageUrl($width = 640, $height = 480),
    ];
});

// $factory->define(App\Album::class, function (Faker $faker) {



//     return [
//     'artist_id' => factory(Artist::class)->create()->id,
//     'album_id' => factory(Album::class)->create()->id,

//     ];
// });