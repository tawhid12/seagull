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
        Schema::create('account_master_sub_bkdn_subs', function (Blueprint $table) {
            $table->id('fcoa_bkdn_sub_id');
            $table->unsignedBigInteger('fcoa_bkdn_id')->index()->foreign('fcoa_bkdn_id')->references('fcoa_bkdn_id')->on('account_master_sub_bkdns')->onDelete('cascade');
            $table->string('fcoa_bkdn_sub',100)->unique();
            $table->string('sub_code',100)->unique();
            $table->decimal('sub_balance',10,2)->nullable()->default(0.00);
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
        Schema::dropIfExists('account_master_sub_bkdn_subs');
    }
};
