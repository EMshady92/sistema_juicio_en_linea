<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEscaneoAnexos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('escaneo_anexos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_expediente')->unsigned ();
            $table->foreign('id_expediente')->references('id')->on('expedientes');
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
        Schema::drop('escaneo_anexos', function (Blueprint $table) {
            //
        });
    }
}
