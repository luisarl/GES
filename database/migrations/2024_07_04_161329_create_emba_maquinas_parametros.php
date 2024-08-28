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
        Schema::create('emba_maquinas_parametros', function (Blueprint $table) {
            $table->integer('id_maquina_parametro')->unsigned();
            $table->primary('id_maquina_parametro');
            $table->unsignedInteger('id_maquina');
            $table->foreign('id_maquina')->references('id_maquina')->on('emba_maquinas')->onUpdate('cascade');
            $table->unsignedInteger('id_parametro');
            $table->foreign('id_parametro')->references('id_parametro')->on('emba_parametros')->onUpdate('cascade');
            $table->double('valor_minimo', 8, 2)->nullable(); 
            $table->double('valor_maximo', 8, 2)->nullable(); 
            $table->integer('orden')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emba_maquinas_parametros');
    }
};
