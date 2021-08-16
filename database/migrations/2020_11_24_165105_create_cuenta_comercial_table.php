<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuentaComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuenta_comercial', function (Blueprint $table) {
            $table->id();
            $table->string('numero_cuenta');
            $table->string('nombre_cuenta');
            $table->string('ciudad')->nullable();
            $table->string('limite_credito')->nullable();
            $table->string('company_rfc')->nullable();
            $table->longText('razon_social')->nullable();
            $table->string('ar')->nullable();
            $table->boolean('credito_habitacion')->default(FALSE);
            $table->boolean('credito_alimentos')->default(FALSE);
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
        Schema::dropIfExists('cuenta_comercial');
    }
}
