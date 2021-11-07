<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titleMovie');
            $table->text('descriptionMovie');
            $table->string('urlImageMovie');
            $table->integer('stockMovie');
            $table->double('rentalPriceMovie',8,2);
            $table->double('purchasePriceMovie',8,2);
            $table->boolean('availabilityMovie');
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
        Schema::dropIfExists('movies');
    }
}
