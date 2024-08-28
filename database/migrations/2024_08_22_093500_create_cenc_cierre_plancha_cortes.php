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
        Schema::create('cenc_cierre_plancha_cortes', function (Blueprint $table) {
            $table->integer('id_cierre_pl_cortes')->primary();
            $table->integer('id_cierre_planchas');
            $table->foreign('id_cierre_planchas')->references('id_cierre_planchas')->on('cenc_cierre_planchas');
            $table->integer('piezas_anidadas')->nullable();
            $table->integer('piezas_cortadas')->nullable();
            $table->integer('piezas_danadas')->nullable();
            $table->float('longitud_corte')->nullable();
            $table->integer('numero_perforaciones')->nullable();
            $table->string('cnc_aprovechamiento')->nullable();
            $table->integer('total_anidadas')->nullable();
            $table->integer('total_cortadas')->nullable();
            $table->integer('total_danadas')->nullable();
            $table->float('total_longitud_corte')->nullable();
            $table->integer('total_perforaciones')->nullable();
            $table->string('creado_por',50)->nullable();
            $table->date('fecha_creado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cenc_cierre_plancha_cortes');
    }
};
