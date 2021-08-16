<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultiplicadorPuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multiplicador_puntos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_finaliza');
            $table->bigInteger('multiplicador');

            //LLave foranea user_id
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->softDeletes();
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
        Schema::dropIfExists('multiplicador_puntos');
    }
}
