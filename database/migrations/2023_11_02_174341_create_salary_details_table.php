<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->index()->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->boolean('inc_type')->default(3)->comment('1=>Percentage 2 => Gross Amount, 3=> initial Insert');
            $table->date('inc_effecting_on')->nullable();
            $table->decimal('final_salary',10,2);
            /*==== Salary will calculate based on active ===*/
            $table->boolean('status')->default(1)->comment('1=>Active 0 => Inactive');
            $table->unsignedBigInteger('created_by')->index()->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable()->index()->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salary_details');
    }
};
