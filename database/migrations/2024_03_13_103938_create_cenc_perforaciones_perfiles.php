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
        Schema::create('cenc_perforaciones_perfiles', function (Blueprint $table) {
            $table->integer('id_perforacion_perfil')->primary();
            $table->integer('id_lperfil');
            $table->float('diametro_perforacion');
            $table->float('t_ala');
            $table->float('s_alma');
            $table->float('cantidad_total');
            $table->timestamps();
            $table->foreign('id_lperfil')->references('id_lperfil')->on('cenc_lista_perfiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_perforaciones_perfiles');
    }
};
