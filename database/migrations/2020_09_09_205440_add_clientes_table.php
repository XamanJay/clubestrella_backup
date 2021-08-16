<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clientes', function (Blueprint $table) {

            //LLave foranea puntos_id
            $table->unsignedBigInteger('puntos_id');
            $table->foreign('puntos_id')->references('id')->on('puntos');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clientes', function (Blueprint $table) {
            
            $table->foreign('puntos_id')->references('id')->on('puntos');

        });
    }
}
