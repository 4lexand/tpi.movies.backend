<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('firstNameUser');
            $table->text('lastNameUser');
            $table->string('phoneUser');
            $table->text('loginNameUser');
            $table->text('loginPasswordUser');
            $table->unsignedBigInteger('idRolUser');
            $table->foreign('idRolUser')->references('id')->on('roles');
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
        Schema::dropIfExists('users');
    }
}
