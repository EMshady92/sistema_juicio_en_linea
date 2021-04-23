<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedientesala extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expedienteSala', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_expediente')->unsigned ();
            $table->foreign('id_expediente')->references('id')->on('expedientes');
            $table->integer('id_sala')->unsigned ();
            $table->foreign('id_sala')->references('id')->on('salaMagistrado');
            $table->integer('id_asignacion')->unsigned()->nullable();
            $table->foreign('id_asignacion')->references('id')->on('users');
            $table->string('estado');
            $table->string('observaciones')->nullable();
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
        Schema::drop('expedienteSala');
    }
}
