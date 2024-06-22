<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Accounts\Child_one;
use App\Models\Accounts\Child_two;
use App\Models\User; 

class AccountHeadTwoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch all users
        $users = User::all();
        // Loop through each user and insert a record into account_head_two
        $child_one = Child_one::where('head_code','1150')->first();
        foreach ($users as $user) {
            $ach = new Child_two;
            $ach->child_one_id = $child_one->id; 
            $ach->head_name = $user->name; 
            $ach->head_code = '1150' . $user->id;
            $ach->opening_balance = 0; 
            $ach->created_by = 1;
            $ach->save();
        }
    }
}
