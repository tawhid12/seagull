<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('contact_no')->unique();
            $table->unsignedBigInteger('role_id')->index()->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->string('password');
            $table->string('image')->nullable();
            // $table->integer('user_type')->default(1)->comment('1 => for Own Employee, 2 => Company Owner');
            // $table->integer('company_id')->default(0);
            $table->boolean('full_access')->default(false)->comment('1=>yes 0=>no');
            $table->integer('department_id')->nullable();
            $table->integer('designation_id')->nullable();
            $table->boolean('status')->default(1)->comment('1=>active 2=>Logged 0 => Inactive');
            $table->string('last_login')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->boolean('permission_type')->default(1)->comment('1=>user based 2=>Role Based');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        DB::table('users')->insert([
            [
                'name' => 'Super Administrator',
                'email' => 'superadmin@email.com',
                'contact_no' => '01600000000',
                'password' => Hash::make('superadmin'),
                'designation_id' => 1,
                'department_id' => 1,
                'role_id' => 1,
                'full_access' => 1,
                'status' => 1,
                'created_by' => 1,
                'created_at' => Carbon::now()
            ],
            [
                'name' => 'Administrator',
                'email' => 'admin@email.com',
                'contact_no' => '01600000001',
                'password' => Hash::make('admin'),
                'designation_id' => 1,
                'department_id' => 1,
                'role_id' => 2,
                'full_access' => 0,
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Mr. Sales Manager',
                'email' => 'salesmanager@email.com',
                'contact_no' => '01600000002',
                'password' => Hash::make('salesmanager'),
                'designation_id' => 1,
                'department_id' => 1,
                'role_id' => 3,
                'full_access' => 0,
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Mr. Sales Executive',
                'email' => 'salesexecutive@email.com',
                'contact_no' => '01600000003',
                'password' => Hash::make('salesexecutive'),
                'designation_id' => 1,
                'department_id' => 1,
                'role_id' => 4,
                'full_access' => 0,
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Mr. Hr Manager',
                'email' => 'hrmanager@email.com',
                'contact_no' => '01600000004',
                'password' => Hash::make('hrmanager'),
                'designation_id' => 1,
                'department_id' => 1,
                'role_id' =>5,
                'full_access' => 0,
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Mr. Hr Executive',
                'email' => 'hr@email.com',
                'contact_no' => '01600000005',
                'password' => Hash::make('hrexecutive'),
                'designation_id' => 1,
                'department_id' => 1,
                'role_id' => 6,
                'full_access' => 0,
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Mr. Accountant Manager',
                'email' => 'accountmanager@email.com',
                'contact_no' => '01600000006',
                'password' => Hash::make('accountmanager'),
                'designation_id' => 1,
                'department_id' => 1,
                'role_id' => 7,
                'full_access' => 0,
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ],
            [
                'name' => 'Mr. Accountant Executive',
                'email' => 'accountant@email.com',
                'contact_no' => '01600000007',
                'password' => Hash::make('accountant'),
                'designation_id' => 1,
                'department_id' => 1,
                'role_id' => 8,
                'full_access' => 0,
                'status' => 1,
                'created_at' => Carbon::now(),
                'created_by' => 1,
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
