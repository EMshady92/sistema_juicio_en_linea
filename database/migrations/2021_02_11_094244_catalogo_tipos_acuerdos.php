<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CatalogoTiposAcuerdos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('catalogo_tipos_acuerdos', function (Blueprint $table) {
            $table->increments('id');    
            $table->string('tipo');    
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
        Schema::drop('catalogo_tipos_acuerdos');
    }
}
