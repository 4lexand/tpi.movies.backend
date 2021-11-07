<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('idUserRent');
            $table->foreign('idUserRent')->references('id')->on('users');
            $table->unsignedBigInteger('idMovieRent');
            $table->foreign('idMovieRent')->references('id')->on('movies');
            $table->timestamp('dateRent', $precision = 0);
            $table->date('returnDateRent');
            $table->integer('quantityRent');
            $table->double('subtotalRent', 8, 2);
            $table->double('totalRent', 8, 2);
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
        Schema::dropIfExists('rents');
    }
}
