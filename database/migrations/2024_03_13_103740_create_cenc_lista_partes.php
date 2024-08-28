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
        Schema::create('cenc_lista_partes', function (Blueprint $table) {
            $table->integer('id_lista_parte')->primary();
            $table->integer('nro_conap');
            $table->string('tipo_lista', 200);
            $table->string('estatus', 200);
            $table->integer('anulado_por')->nullable();
            $table->dateTime('fecha_anulado')->nullable();
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
        Schema::dropIfExists('cenc_lista_partes');
    }
};
