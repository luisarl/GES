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
        Schema::table('asal_salidas_detalle', function (Blueprint $table) {
            $table->renameColumn('cantidad', 'cantidad_salida');
            $table->decimal('cantidad_retorno')->nullable();
            $table->string('estatus')->nullable();
            $table->dateTime('fecha_salida')->nullable();
            $table->dateTime('fecha_retorno')->nullable();
            $table->char('retorna',2)->nullable();//
            $table->string('usuario_retorno')->nullable();
            $table->integer('item')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modificacion_salidas_detalles');
    }
};
