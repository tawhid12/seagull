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
        Schema::create('salary_slips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index()->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->integer('total_working_day');
            $table->integer('total_present');
            $table->integer('total_leave');
            $table->integer('total_absent');
            /*$table->date('from_date');
            $table->date('to_date');*/
            $table->integer('month');
            $table->integer('year');
            $table->boolean('status')->default(2)->comment('1=>paid 2=>Unpaid');
            $table->date('paid_date')->nullable();
            $table->decimal('salary',10,2);
            $table->decimal('deduction',10,2)->default(0.00)->comment('Per month deduct amount if advance salary');
            $table->decimal('absent_deduction',10,2)->default(0.00)->comment('Deduction for Absent');
            $table->boolean('v_status')->default(2)->comment('1=>Posted  2=> Pending');
            $table->string('table_name');
            $table->string('table_id');
            $table->string('account_code');
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
        Schema::dropIfExists('salary_slips');
    }
};
