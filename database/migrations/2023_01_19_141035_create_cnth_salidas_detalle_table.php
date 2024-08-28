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
        Schema::create('cnth_salidas_detalle', function (Blueprint $table) {
            $table->integer('id_detalle')->unsigned();
            $table->primary('id_detalle');
            //Relacion de herramienta
            $table->unsignedInteger('id_herramienta');
            $table->foreign('id_herramienta')->references('id_herramienta')->on('cnth_herramientas');
            //Relacion de entrada
            $table->unsignedInteger('id_salida');
            $table->foreign('id_salida')->references('id_salida')->on('cnth_salidas');
            //Tablas 
            $table->integer('cantidad')->nullable();
            $table->string('nombre_herramienta')->nullable();
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
        Schema::dropIfExists('cnth_salidas_detalle');
    }
};
