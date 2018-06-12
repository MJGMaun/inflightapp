<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Role comes before User seeder here.
        $this->call(RoleTableSeeder::class);
        // User seeder will use the roles above created.
        $this->call(UserTableSeeder::class);
        // Genre seeder will use the genres above created.
        $this->call(GenreTableSeeder::class);
        // Album seeder will use the albums above created.
        $this->call(AlbumTableSeeder::class);
        // Movie factory.
        // factory(App\Model\Movie::class,10)->create();
        // Artist factory.
        factory(App\Artist::class,5)->create();
        // Album factory.
        factory(App\Album::class,15)->create();
    }
}