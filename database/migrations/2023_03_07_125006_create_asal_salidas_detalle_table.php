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
        Schema::create('asal_salidas_detalle', function (Blueprint $table) {
            $table->integer('id_detalle')->unsigned();
            $table->primary('id_detalle');
            $table->string('codigo_articulo',20)->nullable();
            $table->string('nombre_articulo',150);
            $table->string('tipo_unidad')->nullable();
            $table->decimal('cantidad')->nullable();
            $table->string('observacion')->nullable();
            $table->string('comentario')->nullable();

            //relacion con departamento
            $table->unsignedInteger('id_salida')->nullable();
            $table->foreign('id_salida')->references('id_salida')->on('asal_salidas')->onUpdate('cascade');
            //relacion con articulos
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
        Schema::dropIfExists('asal_salidas_detalle');
    }
};
