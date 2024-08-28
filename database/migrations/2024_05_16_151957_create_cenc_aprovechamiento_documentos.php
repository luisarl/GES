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
        Schema::create('cenc_aprovechamiento_documentos', function (Blueprint $table) {
            $table->integer('id_aprovechamiento_documento')->primary();
            $table->integer('id_aprovechamiento')->nullable();
            $table->string('nombre_documento', 100)->nullable();
            $table->string('ubicacion_documento', 100)->nullable();
            $table->string('tipo_documento', 100)->nullable();
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
        Schema::dropIfExists('cenc_aprovechamiento_documentos');
    }
};
