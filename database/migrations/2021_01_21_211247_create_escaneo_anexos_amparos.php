<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscaneoAnexosAmparos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escaneo_anexos_amparos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_amparo')->unsigned ();
            $table->foreign('id_amparo')->references('id')->on('amparos_promociones');
            $table->string('tipo');     
            $table->string('forma');     
            $table->integer('num_anexo');    
            $table->integer('num_hojas');
            $table->string('escaneo_anexos');                   
            $table->timestamps();
            //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('escaneo_anexos_amparos', function (Blueprint $table) {
            //
        });
    }
}
