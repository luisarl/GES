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
        Schema::create('emba_maquinas', function (Blueprint $table) {
            $table->integer('id_maquina')->unsigned();
            $table->primary('id_maquina');
            $table->integer('id_embarcaciones');
            $table->string('nombre_maquina', 150);
            $table->string('descripcion_maquina', 250);
            $table->timestamps();
            $table->foreign('id_embarcaciones')->references('id_embarcaciones')->on('emba_embarcaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emba_maquinas');
    }
};
