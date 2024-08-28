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
        //
        Schema::table('cenc_aprovechamientos', function (Blueprint $table) {
            $table->renameColumn('aceptado_por', 'validado_por');
            $table->renameColumn('fecha_aceptado', 'fecha_validado');
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
