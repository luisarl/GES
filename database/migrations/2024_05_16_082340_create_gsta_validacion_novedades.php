<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gsta_validacion_novedades', function (Blueprint $table) {
            $table->integer('id_validacion_novedades')->primary();
            $table->integer('id_validacion');
            $table->integer('id_novedad');
            $table->timestamps();
            $table->foreign('id_novedad')->references('id_novedad')->on('gsta_novedades');
            $table->foreign('id_validacion')->references('id_validacion')->on('gsta_validaciones_asistencias');
        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gsta_validacion_novedades');
    }
};
