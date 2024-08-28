<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cenc_seguimiento', function (Blueprint $table) {
            $table->integer('id_seguimiento')->primary();
            $table->integer('id_orden_trabajo_plancha');
            $table->foreign('id_orden_trabajo_plancha')->references('id_orden_trabajo_plancha')->on('cenc_orden_trabajo_planchas');
            $table->string('estatus', 50);
            $table->string('creado_por',50);
            $table->dateTime('fecha_creado');
            $table->string('aceptado_por',50)->nullable();
            $table->dateTime('fecha_aceptado')->nullable();
            $table->string('enproceso_por',50)->nullable();
            $table->dateTime('fecha_enproceso')->nullable();
            $table->string('anulado_por',50)->nullable();
            $table->datetime('fecha_anulado')->nullable();
            $table->string('finalizado_por',50)->nullable();
            $table->datetime('fecha_finalizado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cenc_seguimiento');
    }
};
