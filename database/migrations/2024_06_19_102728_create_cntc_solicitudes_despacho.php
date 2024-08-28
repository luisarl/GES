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
        Schema::create('cntc_solicitudes_despacho', function (Blueprint $table) {
            $table->integer('id_solicitud_despacho')->primary();
            $table->integer('id_combustible');
            $table->integer('id_departamento');
            $table->integer('id_departamento_servicio');
            $table->float('total');
            $table->float('total_despachado')->nullable();
            $table->float('stock_final')->nullable();
            $table->string('motivo');
             $table->string('estatus');
            $table->string('creado_por');
            $table->datetime('fecha_creacion');
            $table->string('aceptado_por')->nullable();
            $table->datetime('fecha_aceptado')->nullable();
            $table->string('aprobado_por')->nullable();
            $table->datetime('fecha_aprobacion')->nullable();
            $table->string('anulado_por')->nullable();
            $table->datetime('fecha_anulacion')->nullable();
            $table->timestamps();
            $table->foreign('id_combustible')->references('id_tipo_combustible')->on('cntc_tipo_combustible');
            $table->foreign('id_departamento')->references('id_departamento')->on('departamentos');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cntc_solicitudes_despacho');
    }
};
