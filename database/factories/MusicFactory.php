<?php

use Faker\Generator as Faker;
use App\Album;

$factory->define(App\Music::class, function (Faker $faker) {
    return [
       'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'album_id' => function(){
            return Album::all()->random();
        },
        'genre' => $faker->randomElement($array = array ('OPM','Pop','R&B','Hip-Hop','Rock','Jazz','R&B')),
        'cover_image_id' => '1',
        //$faker->imageUrl($width = 640, $height = 480),
        'music_song' => 'nosong.jpg',
    ];
});
