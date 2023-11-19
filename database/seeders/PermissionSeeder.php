<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert([
            [
                'name' => 'Dashboard',
                'route_name' => 'superadminDashboard',
            ],
            [
                'name' => 'View Roles',
                'route_name' => 'role.index',
            ],
            [
                'name' => 'View Permissions',
                'route_name' => 'permission.index',
            ],
            [
                'name' => 'Create Permissions',
                'route_name' => 'permission.create',
            ],
            [
                'name' => 'Store Permissions',
                'route_name' => 'permission.store',
            ],
            [
                'name' => 'View Users',
                'route_name' => 'adminuser.index',
            ],
            [
                'name' => 'Edit User',
                'route_name' => 'adminuser.edit',
            ],
            [
                'name' => 'Update User',
                'route_name' => 'adminuser.update',
            ],
        ]);
        
    }
}
