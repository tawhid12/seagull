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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->unique();
            $table->string('website')->nullable();
            $table->string('tax_no')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('email')->nullable();
            $table->string('contact_no')->unique();
            $table->boolean('status')->default(1)->comment('1=>active 0 => Inactive');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        /*DB::table('companies')->insert(
            [
                'company_name' => 'Company-1',
                'website' => 'www.seagull.com',
                'tax_no' => '123',
                'email' => 'test@gmail.com',
                'contact_no' => '01600000000',
                'created_by' => 1,
            ]
        );*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
};
