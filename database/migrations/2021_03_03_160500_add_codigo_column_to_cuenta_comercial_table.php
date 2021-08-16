<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCodigoColumnToCuentaComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cuenta_comercial', function (Blueprint $table) {
            $table->string('codigo')->nullable();
            $table->string('srv')->nullable();
            $table->string('src')->nullable();
            $table->string('cro')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cuenta_comercial', function (Blueprint $table) {
            $table->string('codigo');
            $table->string('srv');
            $table->string('src');
            $table->string('cro');
        });
    }
}
