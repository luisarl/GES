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
        Schema::create('cenc_lista_perfiles', function (Blueprint $table) {
            $table->integer('id_lperfil')->primary();
            $table->integer('id_lista_parte');
            $table->integer('id_ficha');
            $table->string('nro_partes', 200);
            $table->integer('cantidad_piezas');
            $table->string('prioridad', 200);
            $table->string('longitud_pieza', 200);
            $table->string('tipo_corte', 200);
            $table->float('peso_unit');
            $table->float('peso_total');
            $table->integer('id_usuario');
            $table->timestamps();
            $table->foreign('id_lista_parte')->references('id_lista_parte')->on('cenc_lista_partes');
            $table->foreign('id_ficha')->references('id_ficha')->on('cenc_fichas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_lista_perfiles');
    }
};
