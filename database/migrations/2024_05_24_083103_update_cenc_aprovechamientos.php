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
        Schema::table('cenc_aprovechamientos', function (Blueprint $table) {
            $table->string('creado_por', 100)->change();
            $table->string('anulado_por', 100)->nullable()->change();
            $table->dateTime('fecha_creado')->nullable();
            $table->dateTime('fecha_aceptado')->nullable();
            $table->string('aceptado_por', 100)->nullable();
            $table->dateTime('fecha_aprobado')->nullable();
            $table->string('aprobado_por', 100)->nullable();
            $table->dateTime('fecha_enproceso')->nullable();
            $table->string('enproceso_por', 100)->nullable();
            $table->dateTime('fecha_finalizado')->nullable();
            $table->string('finalizado_por', 100)->nullable();
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
