<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalaMagistradotable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaMagistrado', function (Blueprint $table) {
            $table->increments('id');
            $table->string('num_sala');         
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
        Schema::drop('salaMagistrado');
    }
}
