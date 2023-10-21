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
        Schema::create('requisitons', function (Blueprint $table) {
            $table->id();
            $table->string('req_slip_no')->unique();
            $table->string('title')->nullable();
            $table->date('postingDate');
            $table->unsignedBigInteger('client_id')->index()->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('vessel_id')->index()->foreign('vessel_id')->references('id')->on('vessels')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->index()->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('qty');
            $table->decimal('amount',10,2)->comment('product price | Amount');
            $table->boolean('req_type')->comment('1=>Product  2=> Other');
            $table->text('des')->nullable();
            $table->boolean('status')->default(2)->comment('1=>Approved  2=> Un approved');
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
        Schema::dropIfExists('requisitons');
    }
};
