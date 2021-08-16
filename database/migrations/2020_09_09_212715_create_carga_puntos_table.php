<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCargaPuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carga_puntos', function (Blueprint $table) {
            $table->id();
            $table->longText('factura_folio');
            $table->string('rfc');
            $table->dateTime('fecha_carga');
            $table->longText('referencia');
            $table->longText('comentarios')->nullable();
            $table->bigInteger('puntos');
            //Poner en un string la fecha/duracion que expiran los puntos
            $table->dateTime('puntos_expira')->nullable();


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
        Schema::dropIfExists('carga_puntos');
    }
}
