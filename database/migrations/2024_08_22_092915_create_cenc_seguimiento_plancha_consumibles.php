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
        Schema::create('cenc_seguimiento_plancha_consumibles', function (Blueprint $table) {
            $table->integer('id_seguimiento_pl_consumible')->primary();
            $table->integer('id_seguimiento_plancha');
            $table->foreign('id_seguimiento_plancha')->references('id_seguimiento_plancha')->on('cenc_seguimiento_planchas');
            $table->string('consumible')->nullable();
            $table->float('consumo')->nullable();
            $table->string('unidad',50)->nullable();
            $table->text('observaciones')->nullable();
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
        Schema::dropIfExists('cenc_seguimiento_plancha_consumibles');
    }
};
