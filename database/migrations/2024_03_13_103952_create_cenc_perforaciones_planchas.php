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
        Schema::create('cenc_perforaciones_planchas', function (Blueprint $table) {
            $table->integer('id_perforacion_plancha')->primary();
            $table->integer('id_plancha');
            $table->float('diametro_perforacion');
            $table->integer('cantidad_perforacion');
            $table->integer('cantidad_total');
            $table->timestamps();
            $table->foreign('id_plancha')->references('id_lplancha')->on('cenc_lista_planchas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_perforaciones_planchas');
    }
};
