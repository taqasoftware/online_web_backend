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
        Schema::create('tblCustomer', function (Blueprint $table) {
            $table->bigIncrements('CustID');
            $table->string('CustName', 150)->unique();
            $table->bigInteger('CustPriceCatID')->unsigned();
            $table->bigInteger('CustRegionID')->unsigned();
            $table->decimal('CustQIDBalance', 10, 2)->default(0.00);
            $table->decimal('CustUSDBanace', 10, 2)->default(0.00);
            $table->timestamps();
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
