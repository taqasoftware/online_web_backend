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
        Schema::create('tblProducts', function (Blueprint $table) {
            $table->bigInteger('ProdID')->unsigned()->index();
            $table->string('ProdName', 200);
            $table->bigInteger('ProdOrgID');
            $table->decimal('ProdSalePrice1', 10, 2)->default(0.00);
            $table->decimal('ProdSalePrice2', 10, 2)->default(0.00);
            $table->decimal('ProdSalePrice3', 10, 2)->default(0.00);
            $table->decimal('ProdSalePrice4', 10, 2)->default(0.00);
            $table->integer('ProdGiftBonus')->default(0);
            $table->integer('ProdGiftQTY')->default(0);
            $table->string('ProdNote', 250)->nullable();
            $table->float('ProdCurrentBalance')->default(0);
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
