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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->longText('order_details')->nullable();
            $table->text('order_subject')->nullable();
            $table->tinyInteger('order_type')->default(1)->comment('1=> Service, 2=> Delivery');
            $table->string('invoice_no')->unique();
            $table->date('invoice_date');
            $table->string('po_no')->unique();
            $table->date('po_date');
            $table->unsignedBigInteger('company_id')->index()->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('client_id')->index()->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('vessel_id')->index()->foreign('vessel_id')->references('id')->on('vessels')->onDelete('cascade');
            $table->string('currency',50);
            $table->decimal('amount',10,2);
            $table->text('remarks');
            $table->date('posted_on')->nullable();
            $table->tinyInteger('paid_status')->default(1)->comment("1 => For Due, 2=> Paid");
            $table->tinyInteger('order_status')->default(1)->comment("1 => Running, 2=> Closed,  3=> Suspend");
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
        Schema::dropIfExists('orders');
    }
};
