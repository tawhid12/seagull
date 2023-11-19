<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assuming you have a User model and a Permission model
        $user = \App\Models\User::find(1); // Replace with your user retrieval logic
        $permissions = \App\Models\Permission::get();
        foreach ($permissions as $permission) {
            if (!$user->permissions->contains($permission)) {
                $user->permissions()->attach($permission);
            }
        }
    }
}
