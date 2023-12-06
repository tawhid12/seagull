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
        //$user = \App\Models\User::find(1); // Replace with your user retrieval logic
        /*$permissions = \App\Models\Permission::get();
        foreach ($permissions as $permission) {
            if (!$user->permissions->contains($permission)) {
                $user->permissions()->attach($permission);
            }
        }*/

        /*=== Sales Executive ==*/
        /*$adminuser = \App\Models\User::find(4);
        $admin_permission = \App\Models\Permission::whereIn('id', [1, 4])->get();
        foreach ($admin_permission as $permission) {
            if (!$adminuser->permissions->contains($permission)) {
                $adminuser->permissions()->attach($permission);
            }
        }*/

        /*=== Accountant ==*/
        /*$accountantnuser = \App\Models\User::find(8);
        $accountant_permission = \App\Models\Permission::whereIn('id', [1])->get();
        foreach ($accountant_permission as $permission) {
            if (!$accountantnuser->permissions->contains($permission)) {
                $accountantnuser->permissions()->attach($permission);
            }
        }*/
    }
}
