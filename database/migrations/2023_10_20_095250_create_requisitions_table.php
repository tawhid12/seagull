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
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->string('req_slip_no')->unique();
            $table->string('title')->nullable();
            $table->date('postingDate');
            $table->unsignedBigInteger('order_id')->index()->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
           /* $table->unsignedBigInteger('client_id')->index()->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('vessel_id')->index()->foreign('vessel_id')->references('id')->on('vessels')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->index()->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->integer('qty');*/
            $table->decimal('order_amount',10,2);
//            $table->boolean('req_type')->comment('1=>Product  2=> Other');
            $table->text('des')->nullable();
            $table->boolean('status')->default(3)->comment('1=>Full Approved  2=> Partial Approved 3=> Un approved');
            $table->unsignedBigInteger('company_id')->index()->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string('table_name');
            $table->string('table_id');
            $table->string('account_code');
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
        Schema::dropIfExists('requisitions');
    }
};
