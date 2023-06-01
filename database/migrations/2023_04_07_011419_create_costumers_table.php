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
                $table->bigInteger('CustID')->primary()->unsigned()->index();
                $table->string('CustName', 150)->unique();
                $table->bigInteger('CustPriceCatID')->unsigned()->index();;
                $table->bigInteger('CustRegionID')->unsigned()->index();;
                $table->decimal('CustQIDBalance', 10, 2)->default(0.00);
                $table->decimal('CustUSDBanace', 10, 2)->default(0.00);
                $table->timestamps();
                
                $table->foreign('CustPriceCatID')->references('PriceCatID')->on('tblPriceCat')->onUpdate('cascade');
                $table->foreign('CustRegionID')->references('RegID')->on('tblRegion')->onUpdate('cascade');
            });
    } 

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('costumers');
    }
};
