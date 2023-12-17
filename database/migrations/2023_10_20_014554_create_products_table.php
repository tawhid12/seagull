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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->unique();
            $table->unsignedBigInteger('category_id')->index()->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->unsignedBigInteger('pro_type_id')->index()->foreign('pro_type_id')->references('id')->on('product_types')->onDelete('cascade');
//            $table->integer('qty')->nullable();
//            $table->decimal('per_unit_price',10,2)->default(0.00);
//            $table->decimal('opening_balance',10,2)->default(0.00);
            $table->string('product_item_code')->nullable();
            $table->string('product_model')->nullable();
            $table->string('manufacturer')->nullable();
            $table->string('brand')->nullable();
            $table->string('manu_country')->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('company_id')->index()->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
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
        Schema::dropIfExists('products');
    }
};
