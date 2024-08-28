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
        Schema::create('cenc_orden_trabajo_planchas', function (Blueprint $table) {
            $table->integer('id_orden_trabajo_plancha')->primary();
            $table->integer('id_orden_trabajo');
            $table->foreign('id_orden_trabajo')->references('id_orden_trabajo')->on('cenc_orden_trabajo');
            $table->integer('id_aprovechamiento');
            $table->foreign('id_aprovechamiento')->references('id_aprovechamiento')->on('cenc_aprovechamientos');
            $table->integer('id_lista_parte');
            $table->foreign('id_lista_parte')->references('id_lista_parte')->on('cenc_lista_partes');
            $table->integer('equipo');
            $table->integer('tecnologia');
            $table->string('tiempo_estimado', 255)->nullable();
            $table->float('consumo_oxigeno')->nullable();
            $table->float('consumo_gas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cenc_orden_trabajo_planchas');
    }
};
