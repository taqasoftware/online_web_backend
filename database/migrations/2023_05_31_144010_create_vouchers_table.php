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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id(); 
            $table->date('voucherDate');
            $table->unsignedBigInteger('voucherCustomerID');
            $table->unsignedBigInteger('voucherAgentID');
            $table->decimal('voucherAccountUSD', 10, 2);
            $table->decimal('voucherAccountQID', 10, 2);
            $table->decimal('voucherPaidUSD', 10, 2);
            $table->decimal('voucherPaidQID', 10, 2);
            $table->decimal('voucherExchangeRate', 10, 4);
            $table->timestamps();

            $table->foreign('voucherCustomerID')->references('CustID')->on('tblCustomer');
            $table->foreign('voucherAgentID')->references('userId')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
};
