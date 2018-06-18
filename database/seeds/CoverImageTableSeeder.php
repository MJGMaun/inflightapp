<?php

use Illuminate\Database\Seeder;
use App\CoverImage;

class CoverImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CoverImage::create(array('cover_image' => 'noimage.jpg'));
    }
}
