<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcuerdosGeneradosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('acuerdosGenarados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_expediente')->unsigned ();
            $table->foreign('id_expediente')->references('id')->on('expedientes');
            $table->integer('id_tipo_acuerdo')->unsigned ();
            $table->foreign('id_tipo_acuerdo')->references('id')->on('catalogo_tipos_acuerdos'); 
            $table->integer('id_promocion')->unsigned()->nullable();
            $table->foreign('id_promocion')->references('id')->on('amparos_promociones');      
            $table->integer('num_folio');
            $table->integer('tiempo_contestacion');    
            $table->string('estado');           
            $table->string('captura');
            $table->string('acuerdo');
            $table->string('observaciones');
            $table->integer('version');  
            $table->binary('acuerdo_text');  
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
        Schema::drop('acuerdosGenarados');
    }
}
