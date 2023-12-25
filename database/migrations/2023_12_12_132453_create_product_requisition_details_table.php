<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_requisition_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_requisition_id')->index()->foreign('product_requisition_id')->references('id')->on('product_requisitons')->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id')->index()->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->index()->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('qty')->nullable();
            $table->decimal('per_unit_price', 10, 2)->default(0.00);
            $table->decimal('discount', 10, 2)->default(0.00);
            $table->decimal('total_payable', 10, 2)->default(0.00);
            $table->boolean('status')->default(2)->comment('1=>Approved  2=> Un approved');
            $table->decimal('approve_amount',10,2)->default(0.00);
            $table->boolean('v_status')->default(3)->comment('1=>Posted  2=> Ongoing 3=> Pending');
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
        Schema::dropIfExists('product_requisition_details');
    }
};
