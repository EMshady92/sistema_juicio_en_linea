<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorialUbicacionExpedientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_ubicacion_expedientes', function (Blueprint $table) {
            $table->increments('id');                       
            $table->integer('id_expediente')->unsigned()->nullable();
            $table->foreign('id_expediente')->references('id')->on('expedientes'); 
            $table->integer('id_user_entrega')->unsigned()->nullable();
            $table->foreign('id_user_entrega')->references('id')->on('users'); 
            $table->integer('id_user_recibe')->unsigned()->nullable();
            $table->foreign('id_user_recibe')->references('id')->on('users'); 
            $table->string('tipo_movimiento');
            $table->string('ubicacion');
            $table->string('estado');
            $table->string('captura');      
            $table->string('observaciones')->nullable();         
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
        Schema::drop('historial_ubicacion_expedientes');
    }
}
