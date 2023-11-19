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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('address')->nullable();
            $table->integer('district_id')->nullable();
            $table->integer('designation_id')->nullable();
            // $table->integer('country_id')->nullable();
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('education_qualification')->nullable();
            $table->string('mobile_no')->unique();
            $table->boolean('status')->default(1)->comment('1=>active 0 => Resigned');
            $table->date('resign_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->decimal('salary',10,2);
            $table->date('joining_date');
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
        Schema::dropIfExists('employees');
    }
};
