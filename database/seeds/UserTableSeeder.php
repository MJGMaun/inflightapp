<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role_passenger = Role::where('name', 'passenger')->first();
        $role_admin  = Role::where('name', 'admin')->first();
        $passenger = new User();
        $passenger->name = 'passenger Name';
        $passenger->email = 'passenger@example.com';
        $passenger->password = bcrypt('secret');
        $passenger->save();
        $passenger->roles()->attach($role_passenger);
        $admin = new User();
        $admin->name = 'admin Name';
        $admin->email = 'admin@example.com';
        $admin->password = bcrypt('secret');
        $admin->save();
        $admin->roles()->attach($role_admin);
    }
}
