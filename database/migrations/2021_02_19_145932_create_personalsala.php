<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalsala extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personalSala', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_sala')->unsigned ();
            $table->foreign('id_sala')->references('id')->on('salaMagistrado');     
            $table->integer('id_user')->unsigned ();
            $table->foreign('id_user')->references('id')->on('users');       
            $table->string('funcion');    
            $table->string('estado');          
            $table->string('captura');
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
        Schema::drop('personalSala');
    }
}
