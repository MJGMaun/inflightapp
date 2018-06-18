<?php

use Illuminate\Database\Seeder;
use App\Album;

class AlbumTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Album::create(array('album_name' => 'Single Only', 'artist_id' => '0', 'cover_image_id' => '1'));
    }
}
