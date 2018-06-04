<?php


use Illuminate\Database\Seeder;
use App\Genre;

class GenreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Genre::create(array('name' => 'Action'));
        Genre::create(array('name' => 'Kids'));
        Genre::create(array('name' => 'Comedy'));
        Genre::create(array('name' => 'Drama'));
        Genre::create(array('name' => 'Horror'));
        Genre::create(array('name' => 'Romance'));
        Genre::create(array('name' => 'Sci-Fi & Fantasy'));
        Genre::create(array('name' => 'Adventure'));
    }
}
