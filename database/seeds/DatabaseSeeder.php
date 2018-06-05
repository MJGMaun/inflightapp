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
        // Movie factory.
        factory(App\Model\Movie::class,10)->create();
    }
}