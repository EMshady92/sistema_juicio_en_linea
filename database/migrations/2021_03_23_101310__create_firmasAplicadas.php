<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFirmasAplicadas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('firmasaplicadas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_firma')->unsigned ();
            $table->foreign('id_firma')->references('id')->on('firmaElectronica');
            $table->integer('id_asignacion')->unsigned()->nullable();
            $table->foreign('id_asignacion')->references('id')->on('asignaciones_firma'); 
            $table->integer('num_firma');  
            $table->binary('firma'); 
            $table->binary('firma_64');      
            $table->string('firma_ruta');                    
            $table->string('xml');
            $table->string('pdf');
            $table->string('zip');
            $table->string('estado');                     
            $table->string('captura');
            $table->string('clave_alfanumerica');            
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
        Schema::drop('firmasaplicadas');
    }
}
