<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsignacionesFirma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asignaciones_firma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_acuerdo')->unsigned()->nullable();
            $table->foreign('id_acuerdo')->references('id')->on('acuerdosgenarados');
            $table->integer('id_user')->unsigned()->nullable();
            $table->foreign('id_user')->references('id')->on('users');
            $table->integer('id_solicita')->unsigned()->nullable();
            $table->foreign('id_solicita')->references('id')->on('users');
            $table->integer('num_asignacion');
            $table->string('num_expediente');
            $table->string('clave_alfanumerica');
            $table->string('docx');
            $table->binary('txt');
            $table->string('tipo_documento')->nullable();
            $table->string('tipo_expediente')->nullable();
            $table->string('tipo_juicio')->nullable();
            $table->string('observaciones')->nullable();
            $table->string('estado');                     
            $table->string('captura'); 
            $table->string('ponente')->nullable();
            $table->string('proyectista')->nullable();
            $table->string('auto')->nullable();
            $table->string('actores')->nullable();
            $table->string('sala')->nullable();
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
        Schema::drop('asignaciones_firma');
    }
}
