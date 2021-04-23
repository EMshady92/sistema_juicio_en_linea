<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubdependencias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subdependencias', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_dependencia')->unsigned ();
            $table->foreign('id_dependencia')->references('id')->on('personas');
            $table->string('tipo');
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('sexo')->nullable();
            $table->string('rfc')->unique()->nullable();
            $table->string('telefono')->unique()->nullable();
            $table->string('celular')->unique()->nullable();
            $table->string('curp')->unique()->nullable();
            $table->integer('num_cedula')->nullable();
            $table->string('cedula')->nullable();
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
        Schema::drop('subdependencias');
    }
}
