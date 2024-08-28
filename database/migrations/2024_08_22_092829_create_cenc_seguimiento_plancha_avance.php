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
        Schema::create('cenc_seguimiento_plancha_avance', function (Blueprint $table) {
            $table->integer('id_seguimiento_pl_avance')->primary();
            $table->integer('id_seguimiento_plancha');
            $table->foreign('id_seguimiento_plancha')->references('id_seguimiento_plancha')->on('cenc_seguimiento_planchas');

            $table->string('nro_partes', 200);
            $table->string('descripcion', 200);
            $table->string('dimensiones', 200);
            $table->integer('cantidad_piezas');
            $table->float('peso_unitario');
            $table->float('peso_total');

            $table->integer('avance_cant_piezas')->nullable();
            $table->float('avance_peso')->nullable();
            $table->integer('pendiente_cant_piezas')->nullable();
            $table->float('pendiente_peso')->nullable();

            $table->integer('prod_cant_piezas_avance')->nullable();
            $table->float('prod_peso_total_avance')->nullable();
            $table->integer('pend_cant_piezas_avance')->nullable();
            $table->float('pend_peso_avance')->nullable();

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
        Schema::dropIfExists('cenc_seguimiento_plancha_avance');
    }
};
