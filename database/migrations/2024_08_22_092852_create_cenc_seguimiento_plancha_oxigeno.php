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
        Schema::create('cenc_seguimiento_plancha_oxigeno', function (Blueprint $table) {
            $table->integer('id_seguimiento_pl_oxigeno')->primary();
            $table->integer('id_seguimiento_plancha');
            $table->foreign('id_seguimiento_plancha')->references('id_seguimiento_plancha')->on('cenc_seguimiento_planchas');
            $table->float('oxigeno_inicial')->nullable();
            $table->float('oxigeno_final')->nullable();
            $table->float('oxigeno_usado')->nullable();
            $table->string('cambio')->nullable();
            $table->float('litros_gaseosos')->nullable();
            $table->float('total_oxigeno_usado')->nullable();
            $table->float('total_litros_gaseosos')->nullable();
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
        Schema::dropIfExists('cenc_seguimiento_plancha_oxigeno');
    }
};
