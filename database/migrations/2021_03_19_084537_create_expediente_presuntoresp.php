<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedientePresuntoresp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expediente_presuntoresp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_expediente')->unsigned ();
            $table->foreign('id_expediente')->references('id')->on('expedientes');
            $table->integer('id_presuntoresp')->unsigned ();
            $table->foreign('id_presuntoresp')->references('id')->on('personas');
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
        Schema::drop('expediente_presuntoresp');
    }
}
