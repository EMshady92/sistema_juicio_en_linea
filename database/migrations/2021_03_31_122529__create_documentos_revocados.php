<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentosRevocados extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documentos_revocados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_firma')->unsigned ();
            $table->foreign('id_firma')->references('id')->on('firmasaplicadas');
            $table->integer('id_asignacion')->unsigned()->nullable();
            $table->foreign('id_asignacion')->references('id')->on('asignaciones_firma'); 
            $table->string('motivo');                      
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
        Schema::drop('firmas_revocadas');
    }
}
