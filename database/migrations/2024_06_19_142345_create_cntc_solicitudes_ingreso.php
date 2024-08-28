<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cntc_solicitudes_ingreso', function (Blueprint $table) {
            $table->integer('id_solicitud_ingreso')->primary();
            $table->integer('id_tipo_ingreso');
            $table->integer('id_combustible');
            $table->integer('id_departamento');
            $table->float('cantidad');
            $table->float('stock_anterior')->nullable();
            $table->string('observacion');
            $table->string('creado_por');
            $table->dateTime('fecha_creacion');
            $table->timestamps();
            $table->foreign('id_combustible')->references('id_tipo_combustible')->on('cntc_tipo_combustible');
            $table->foreign('id_departamento')->references('id_departamento')->on('departamentos');
            $table->foreign('id_tipo_ingreso')->references('id_tipo_ingresos')->on('cntc_tipo_ingresos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cntc_solicitudes_ingreso');
    }
};
