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
        Schema::create('cenc_lista_planchas', function (Blueprint $table) {
            $table->integer('id_lplancha')->primary();
            $table->integer('id_lista_parte');
            $table->string('nro_partes', 200);
            $table->string('descripcion', 200);
            $table->string('prioridad', 200);
            $table->string('dimensiones', 200);
            $table->integer('espesor');
            $table->integer('cantidad_piezas');
            $table->float('peso_unit');
            $table->float('peso_total');
            $table->integer('id_usuario');
            $table->timestamps();
            $table->foreign('id_lista_parte')->references('id_lista_parte')->on('cenc_lista_partes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_lista_planchas');
    }
};
