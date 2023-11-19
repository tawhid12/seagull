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
        Schema::create('salary_advance_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index()->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->decimal('adv_salary',10,2);
            $table->decimal('deduction',10,2)->comment('Per month deduct amount');
            $table->decimal('balance',10,2)->comment('After Every Month Adjust');
            $table->date('paid_date');
            $table->integer('month');
            $table->integer('year');
            $table->boolean('status')->default(0)->comment('1=>Adjusted 0 => No Adjusted');
            $table->date('adjusted_on')->nullable();
            $table->unsignedBigInteger('created_by')->index()->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('updated_by')->nullable()->index()->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->text('note')->nullable();
            $table->boolean('v_status')->default(2)->comment('1=>Posted  2=> Pending');
            $table->string('table_name');
            $table->string('table_id');
            $table->string('account_code');
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
        Schema::dropIfExists('salary_advance_payments');
    }
};
