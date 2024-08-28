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
        Schema::create('cenc_aprovechamiento_planchas', function (Blueprint $table) {
            $table->integer('id_aprovechamiento_plancha')->primary();
            $table->integer('id_aprovechamiento');
            $table->string('nombre_equipo', 50);
            $table->string('nombre_tecnologia', 50);
            $table->float('espesor');
            $table->string('longitud_corte', 255);
            $table->integer('numero_piercing');
            $table->string('tiempo_estimado');
            $table->string('juego_antorcha', 50)->nullable();
            $table->string('numero_boquilla', 50)->nullable();
            $table->string('precalentamiento', 20)->nullable();
            $table->integer('tiempo_precalentamiento')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->foreign('id_aprovechamiento')->references('id_aprovechamiento')->on('cenc_aprovechamientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_aprovechamiento_planchas');
    }
};
