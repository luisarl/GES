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
        Schema::create('cenc_orden_trabajo', function (Blueprint $table) {
            $table->integer('id_orden_trabajo')->primary();
            $table->integer('id_conap');
            $table->foreign('id_conap')->references('id_conap')->on('cenc_conaps');
            $table->string('estatus', 50);
            $table->text('observaciones')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_fin')->nullable();
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
        Schema::dropIfExists('cenc_orden_trabajo');
    }
};
