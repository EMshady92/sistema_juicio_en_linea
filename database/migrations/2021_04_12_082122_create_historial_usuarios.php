<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistorialUsuarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->unsigned()->nullable();
            $table->foreign('id_user')->references('id')->on('users'); 
            $table->string('tipo_movimiento');
            $table->string('tabla')->nullable();
            $table->string('id_aux')->nullable();
            $table->json ('valor_nuevo')->nullable();
            $table->json ('valor_anterior')->nullable();
            $table->string('observaciones')->nullable();
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
        Schema::drop('historial_usuarios');
    }
}
