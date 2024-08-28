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
        Schema::create('cenc_aprovechamientos', function (Blueprint $table) {
            $table->integer('id_aprovechamiento')->primary();
            $table->unsignedInteger('id_lista_parte');
			$table->foreign('id_lista_parte')->references('id_lista_parte')->on('cenc_lista_partes')->onUpdate('cascade');
            $table->string('estatus', 50);
            $table->integer('creado_por');
            $table->integer('anulado_por')->nullable();
            $table->datetime('fecha_anulado')->nullable();
            $table->timestamps();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_aprovechamientos');
    }
};
