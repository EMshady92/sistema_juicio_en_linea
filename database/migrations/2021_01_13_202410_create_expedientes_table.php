<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expedientes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_juicio')->unsigned ();
            $table->foreign('id_juicio')->references('id')->on('tipos_juicios');
            $table->string('num_expediente');
            $table->string('tipo');
            $table->date('fecha');
            $table->string('observaciones')->nullable();
            $table->string('estado');
            $table->string('ubicacion');
            $table->string('estado_ubicacion');
            $table->integer('id_recibe')->unsigned()->nullable();
            $table->foreign('id_recibe')->references('id')->on('users'); 
            $table->integer('id_entrego')->unsigned()->nullable();
            $table->foreign('id_entrego')->references('id')->on('users'); 
            $table->string('captura');
            $table->integer('id_falta')->unsigned()->nullable();
            $table->foreign('id_falta')->references('id')->on('tipoFalta');
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
        Schema::drop('expedientes');
    }
}
