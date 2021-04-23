<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpedienteDenunciante extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expediente_deunciante', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_expediente')->unsigned ();
            $table->foreign('id_expediente')->references('id')->on('expedientes');
            $table->integer('id_deunciante')->unsigned ();
            $table->foreign('id_deunciante')->references('id')->on('personas');
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
        Schema::drop('expediente_deunciante');
    }
}
