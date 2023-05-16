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
        Schema::create('tblInvoiceDetail', function (Blueprint $table) {
            $table->bigIncrements('DetailID');
            $table->unsignedBigInteger('DetailInvoiceID');
            $table->unsignedBigInteger('DetailProdID');
            $table->float('DetailQTY')->default(0);
            $table->float('DetailGIFT')->default(0);
            $table->float('DetailUnitPrice')->default(0);
            $table->timestamps();

            $table->foreign('DetailProdID')->references('ProdID')->on('tblProducts')->onUpdate('cascade');
            $table->foreign('DetailInvoiceID')->references('InvoiceID')->on('tblInvoiceMain')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_details');
    }
};
