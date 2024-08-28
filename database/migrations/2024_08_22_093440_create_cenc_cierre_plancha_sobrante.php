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
        Schema::create('cenc_cierre_plancha_sobrante', function (Blueprint $table) {
            $table->integer('id_cierre_pl_sobrante')->primary();
            $table->integer('id_cierre_planchas');
            $table->foreign('id_cierre_planchas')->references('id_cierre_planchas')->on('cenc_cierre_planchas');
            $table->string('descripcion');
            $table->string('referencia');
            $table->integer('cantidad');
            $table->string('ubicacion');
            $table->text('observacion');
            $table->string('creado_por',50);
            $table->date('fecha_creado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cenc_cierre_plancha_sobrante');
    }
};
