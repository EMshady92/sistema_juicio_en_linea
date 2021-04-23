<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EmailUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->unique();
            $table->integer('id_personas')->unsigned()->nullable();
            $table->foreign('id_personas')->references('id')->on('personas'); 
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
        Schema::drop('email_users');
    }
}
