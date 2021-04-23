<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->string('nombre')->nullable();
            $table->string('apellido_paterno')->nullable();
            $table->string('apellido_materno')->nullable();
            $table->string('razon_social')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('sexo')->nullable();
            $table->string('rfc')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();
            $table->string('curp')->nullable();
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
        Schema::drop('actor');
    }
}
