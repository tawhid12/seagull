<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('type',20)->unique();
            $table->string('identity',30)->unique();
            $table->timestamps();
        });
        DB::table('roles')->insert([
            [
                'type' => 'Super Administrator',
                'identity' => 'superadmin',
                'created_at' => Carbon::now()
            ],
            [
                'type' => 'Administrator',
                'identity' => 'admin',
                'created_at' => Carbon::now()
            ],
            [
                'type' => 'Sales Manager',
                'identity' => 'salesmanager',
                'created_at' => Carbon::now()
            ],
            [
                'type' => 'Sales Executive',
                'identity' => 'salesexecutive',
                'created_at' => Carbon::now()
            ],
            [
                'type' => 'Human Resource Manager',
                'identity' => 'hrmanager',
                'created_at' => Carbon::now()
            ],
            [
                'type' => 'Human Resource Executive',
                'identity' => 'hrexecutive',
                'created_at' => Carbon::now()
            ],
            [
                'type' => 'Accounts Manager',
                'identity' => 'accountmanager',
                'created_at' => Carbon::now()
            ],
            [
                'type' => 'Accountant',
                'identity' => 'accountant',
                'created_at' => Carbon::now()
            ],

        ]);
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
