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
       
        Schema::create('tblInvoiceMain', function (Blueprint $table) {
            $table->bigIncrements('InvoiceID');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('InvoiceCustID')->unsigned();
            $table->dateTime('InvoiceDate')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('InvoiceStatus')->default(0);
            $table->foreign('InvoiceCustID')->references('CustID')->on('tblCustomer')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->index('user_id');
            $table->index('InvoiceCustID');
            $table->index('InvoiceDate');
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
        Schema::dropIfExists('invoices');
    }
};
