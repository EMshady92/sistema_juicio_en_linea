<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmparosPromocionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('amparos_promociones', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_expediente')->unsigned ();
            $table->foreign('id_expediente')->references('id')->on('expedientes');
            $table->string('folio');
            $table->string('tipo');
            $table->integer('num_anexos');
            $table->integer('hojas_escrito');
            $table->string('escaneo_escrito');
            $table->date('fecha');
            $table->string('estado');
            $table->string('ubicacion');
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
        Schema::drop('amparos');
    }
}
