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
        Schema::create('emba_registros_parametros', function (Blueprint $table) {
            $table->integer('id_registro_parametro')->unsigned();
            $table->primary('id_registro_parametro');
            $table->unsignedInteger('id_maquina');
            $table->foreign('id_maquina')->references('id_maquina')->on('emba_maquinas')->onUpdate('cascade');
            $table->unsignedInteger('id_parametro');
            $table->foreign('id_parametro')->references('id_parametro')->on('emba_parametros')->onUpdate('cascade');
            $table->double('valor', 8, 2);
            $table->date('fecha');
            $table->time('hora', $precision = 0);
            $table->integer('creado_por');
            $table->integer('actualizado_por');
            $table->string('observaciones', 300);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emba_registros_parametros');
    }
};
