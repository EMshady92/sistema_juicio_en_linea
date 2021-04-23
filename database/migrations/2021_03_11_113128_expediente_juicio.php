<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ExpedienteJuicio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expediente_juicio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_expediente')->unsigned ();
            $table->foreign('id_expediente')->references('id')->on('expedientes');
            $table->integer('id_juicio')->unsigned ();
            $table->foreign('id_juicio')->references('id')->on('tipos_juicios');
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
        Schema::drop('expediente_juicios');
    }
}
