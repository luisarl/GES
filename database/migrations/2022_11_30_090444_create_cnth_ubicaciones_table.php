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
        Schema::create('cnth_ubicaciones', function (Blueprint $table) {
            $table->integer('id_ubicacion')->unsigned();
            $table->primary('id_ubicacion');
            $table->string('nombre_ubicacion',50);
            $table->string('codigo_ubicacion',50)->nullable();
            $table->string('creado_por',50)->nullable();
            $table->string('actualizado_por',50)->nullable();
            //llave foranea de tabla almacen
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes')->onUpdate('cascade');
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
        Schema::dropIfExists('cnth_ubicaciones');
    }
};
