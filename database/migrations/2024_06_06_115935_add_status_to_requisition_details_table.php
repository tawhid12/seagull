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
        Schema::table('requisitions', function (Blueprint $table) {
            $table->decimal('approve_amount',10,2)->default(0.00)->after('order_amount');
            $table->boolean('v_status')->default(0)->comment('1=>Posted  0=> Pending')->after('approve_amount');
            $table->tinyInteger('status')->default(0)->comment('1=> Approve , 0=> Unapprove')->after('des');
            $table->unsignedBigInteger('approved_by')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requisitions', function (Blueprint $table) {
            $table->dropColumn('approve_amount'); 
            $table->dropColumn('v_status'); 
            $table->dropColumn('postingDate'); 
            $table->dropColumn('status'); 
            $table->dropColumn('approved_by'); 
        });
    }
};
