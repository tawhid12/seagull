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
        Schema::create('product_requisitons', function (Blueprint $table) {
            $table->id();
            $table->string('req_slip_no')->unique();
            $table->string('title')->nullable();
            $table->unsignedBigInteger('order_id')->index()->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->date('postingDate');
            $table->text('des')->nullable();
            $table->boolean('payment_status')->default(2)->comment('1=>Fullpaid  2=> Partial Paid 3=> Due');
            $table->unsignedBigInteger('company_id')->index()->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            /*$table->string('table_name');
            $table->string('table_id');
            $table->string('account_code');*/
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('product_requisitons');
    }
};
