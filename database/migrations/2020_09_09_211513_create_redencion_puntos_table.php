<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRedencionPuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('redencion_puntos', function (Blueprint $table) {
            $table->id();
            $table->longText('comentarios');
            $table->bigInteger('puntos');
            $table->dateTime('fecha_redencion');
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_salida')->nullable();
            $table->integer('cuartos')->nullable();
            $table->integer('noches')->nullable();
            $table->integer('extra_pax')->nullable();
            $table->string('representante')->nullable();

            //LLave foranea user_id
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            //LLave foranea regalo_id
            $table->unsignedBigInteger('regalo_id');
            $table->foreign('regalo_id')->references('id')->on('regalos');

            

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
        Schema::dropIfExists('redencion_puntos');
    }
}
