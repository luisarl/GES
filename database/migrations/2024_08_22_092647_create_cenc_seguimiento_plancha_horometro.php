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
        Schema::create('cenc_seguimiento_plancha_horometro', function (Blueprint $table) {
            $table->integer('id_seguimiento_pl_horometro')->primary();
            $table->integer('id_seguimiento_plancha');
            $table->foreign('id_seguimiento_plancha')->references('id_seguimiento_plancha')->on('cenc_seguimiento_planchas');
            $table->string('horometro_inicial_on', 100)->nullable();
            $table->string('horometro_final_on', 100)->nullable();
            $table->string('horas_hms_on', 100)->nullable();
            $table->string('horas_on', 100)->nullable();
            $table->string('total_horas_on', 100)->nullable();
            $table->string('horometro_inicial_aut', 100)->nullable();
            $table->string('horometro_final_aut', 100)->nullable();
            $table->string('tiempo_hms_aut', 100)->nullable();
            $table->string('tiempo_aut', 100)->nullable();
            $table->string('total_tiempo_aut', 100)->nullable();
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
        Schema::dropIfExists('cenc_seguimiento_plancha_horometro');
    }
};
