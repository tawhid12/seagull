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
        Schema::create('leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index()->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->unsignedBigInteger('leave_type_id')->index()->foreign('leave_type_id')->references('id')->on('leave_types')->onDelete('cascade');
            $table->date('from_date');
            $table->date('to_date');
            $table->text('note')->nullable();
            $table->boolean('status')->default(2)->comment('1=>approve 2=>unapproved');
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
        Schema::dropIfExists('leaves');
    }
};
