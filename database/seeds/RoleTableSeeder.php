<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_passenger = new Role();
        $role_passenger->name = 'passenger';
        $role_passenger->description = 'A passenger User';
        $role_passenger->save();
        $role_admin = new Role();
        $role_admin->name = 'admin';
        $role_admin->description = 'A admin User';
        $role_admin->save();
    }
}
