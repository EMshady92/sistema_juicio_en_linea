<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlVersionesAcuerdo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('controlVersionesAcuerdo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_acuerdo')->unsigned ();
            $table->foreign('id_acuerdo')->references('id')->on('acuerdosGenarados'); 
            $table->binary('acuerdo_text');                          
            $table->string('acuerdo');
            $table->integer('version');  
            $table->string('observaciones');                     
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
        Schema::drop('controlVersionesAcuerdo');
    }
}
