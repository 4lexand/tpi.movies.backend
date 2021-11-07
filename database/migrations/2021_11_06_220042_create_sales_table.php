<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idUserSale');
            $table->foreign('idUserSale')->references('id')->on('users');
            $table->unsignedBigInteger('idMovieSale');
            $table->foreign('idMovieSale')->references('id')->on('movies');
            $table->timestamp('dateSale', $precision = 0);
            $table->integer('quantitySale');
            $table->double('subtotalSale', 8, 2);
            $table->double('totalSale', 8, 2);
            $table->timestamps(); //createdAt and updateAt
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
