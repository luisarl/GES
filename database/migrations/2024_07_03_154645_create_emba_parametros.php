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
        Schema::create('emba_parametros', function (Blueprint $table) {
            $table->integer('id_parametro')->unsigned();
            $table->primary('id_parametro');
            $table->string('nombre_parametro', 150);
            $table->string('descripcion_parametro', 250);
            $table->integer('id_unidad');
            $table->timestamps();
            $table->foreign('id_unidad')->references('id_unidad')->on('emba_unidades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emba_parametros');
    }
};
