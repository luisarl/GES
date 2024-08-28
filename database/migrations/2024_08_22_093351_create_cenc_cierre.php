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
        Schema::create('cenc_cierre', function (Blueprint $table) {
            $table->integer('id_cierre')->primary();
            $table->integer('id_seguimiento');
            $table->foreign('id_seguimiento')->references('id_seguimiento')->on('cenc_seguimiento');
            $table->string('creado_por',50)->nullable();
            $table->dateTime('fecha_creado')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cenc_cierre');
    }
};
