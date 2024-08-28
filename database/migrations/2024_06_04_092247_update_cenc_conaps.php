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
        Schema::table('cenc_conaps', function (Blueprint $table) {
            $table->string('creado_por', 100)->nullable();
            $table->dateTime('fecha_creado')->nullable();
            $table->string('aprobado_por', 100)->nullable();
            $table->dateTime('fecha_aprobado')->nullable();
            $table->string('anulado_por', 100)->nullable();
            $table->dateTime('fecha_anulado')->nullable();
            $table->string('finalizado_por', 100)->nullable();
            $table->dateTime('fecha_finalizado')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
