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
        Schema::create('emba_novedades', function (Blueprint $table) {
            $table->integer('id_novedad')->unsigned();
            $table->primary('id_novedad');
            $table->integer('id_embarcacion');
            $table->string('motivo_novedad', 150);
            $table->text('descripcion_novedad'); 
            $table->timestamps();
            $table->foreign('id_embarcacion')->references('id_embarcaciones')->on('emba_embarcaciones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emba_novedades');
    }
};
