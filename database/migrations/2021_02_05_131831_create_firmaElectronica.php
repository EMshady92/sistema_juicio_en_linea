<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmaElectronica extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmaElectronica', function (Blueprint $table) {           
            $table->increments('id');
            $table->binary('certificado');   
            $table->binary('clave_privada');   
            $table->integer('id_usuario')->unsigned ();
            $table->foreign('id_usuario')->references('id')->on('users');
            $table->string('serial');           
            $table->string('captura');
            $table->string('cert');
            $table->string('llave');
            $table->string('password');
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
        Schema::drop('firmaElectronica');
    }
}
