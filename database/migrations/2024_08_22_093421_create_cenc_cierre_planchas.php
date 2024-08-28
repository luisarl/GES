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
        Schema::create('cenc_cierre_planchas', function (Blueprint $table) {
            $table->integer('id_cierre_planchas')->primary();
            $table->integer('id_cierre');
            $table->foreign('id_cierre')->references('id_cierre')->on('cenc_cierre');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cenc_cierre_planchas');
    }
};
