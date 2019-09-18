<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;
use App\Profile;

class AdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create([
            'name'=>'customer',
            'description' => 'Customer Role'
        ]);

        $role = Role::create([
            'name'=>'admin',
            'description' => 'Admin Role'
        ]);

        $user = User::create([
            'email' => 'admin@admin.com',
            'password' => bcrypt('5523'),
            'role_id' => $role->id
        ]);

        $profile = Profile::create([
            'user_id' => $user->id ,
            'slug'    => 'admin'
        ]);
    }
}
