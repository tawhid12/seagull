<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //PermissionSeeder::class,
            //UserPermissionsTableSeeder::class,
        ]);
        DB::table('permissions')->insert([
            'role_id' => 4,
            'name' => 'salesExecutiveCompany',
        ]);
    }
}
