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
        Schema::create('account_master_subs', function (Blueprint $table) {
            $table->id('fcoa_id');
            $table->unsignedBigInteger('fcoa_master_id')->index()->foreign('fcoa_master_id')->references('master_id')->on('account_masters')->onDelete('cascade');
            $table->string('fcoa',100)->unique();
            $table->string('fcoa_code',100)->unique();
            $table->decimal('fcoa_balance',10,2)->nullable()->default(0.00);
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
        Schema::dropIfExists('account_master_subs');
    }
};
