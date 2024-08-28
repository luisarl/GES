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
        Schema::create('cenc_aprovechamiento_planchas_materia_prima', function (Blueprint $table) {
            $table->integer('id_materia_prima')->primary();
            $table->integer('id_aprovechamiento_plancha');
            $table->string('codigo_materia', 50);
            $table->string('dimensiones', 255);
            $table->integer('cantidad');
            $table->float('peso_unit');
            $table->float('peso_total')->nullable();
            $table->timestamps();
            $table->foreign('id_aprovechamiento_plancha')->references('id_aprovechamiento_plancha')->on('cenc_aprovechamiento_planchas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_aprovechamiento_planchas_materia_prima');
    }
};
