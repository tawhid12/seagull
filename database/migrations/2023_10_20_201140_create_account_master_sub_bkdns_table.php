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
        Schema::create('account_master_sub_bkdns', function (Blueprint $table) {
            $table->id('fcoa_bkdn_id');
            $table->unsignedBigInteger('fcoa_id')->index()->foreign('fcoa_id')->references('fcoa_id')->on('account_master_subs')->onDelete('cascade');
            $table->string('fcoa_bkdn',100)->unique();
            $table->string('bkdn_code',100)->unique();
            $table->decimal('bkdn_balance',10,2)->nullable()->default(0.00);
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
        Schema::dropIfExists('account_master_sub_bkdns');
    }
};
