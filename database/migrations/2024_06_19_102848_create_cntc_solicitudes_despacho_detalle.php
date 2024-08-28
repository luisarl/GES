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
        Schema::create('cntc_solicitudes_despacho_detalle', function (Blueprint $table) {
            $table->integer('id_solicitud_despacho_detalle')->primary();
            $table->integer('id_solicitud_despacho');
            $table->string('placa_equipo');
            $table->string('marca_equipo');
            $table->string('responsable');
            $table->float('cantidad');
            $table->float('cantidad_despachada')->nullable();
            $table->date('fecha_despacho')->nullable();
            $table->float('stock_combustible')->nullable();
            $table->timestamps();
            $table->foreign('id_solicitud_despacho')->references('id_solicitud_despacho')->on('cntc_solicitudes_despacho');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cntc_solicitudes_despacho_detalle');
    }
};
