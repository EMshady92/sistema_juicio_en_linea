<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('apellido_p');
            $table->string('apellido_m');
            $table->string('sexo');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->string('passfirma', 60)->nullable();
            $table->rememberToken();
            $table->string('estado');
            $table->string('funcion');
            $table->string('tipo_usuario');
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
        Schema::drop('users');
    }
}
