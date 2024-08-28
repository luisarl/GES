<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::create('cnth_almacen_herramientas', function (Blueprint $table) {
            $table->id('id_almacen_herramienta');
            //inicio de relaciones entre las tablas
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes');
            //llave foranea con herramienta
            $table->unsignedInteger('id_herramienta');
            $table->foreign('id_herramienta')->references('id_herramienta')->on('cnth_herramientas');
            //lalve foranea con ubicaciones
            $table->unsignedInteger('id_ubicacion');
            $table->foreign('id_ubicacion')->references('id_ubicacion')->on('cnth_ubicaciones');
            //lalve foranea con empresas
            $table->unsignedInteger('id_empresa');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresas');
            //tablas de stock 
            $table->integer('stock_inicial')->nullable();
            $table->integer('stock_actual')->nullable();
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
        Schema::dropIfExists('cnth_almacen_herramientas');
    }
};
