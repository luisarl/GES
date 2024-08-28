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
        Schema::create('cnth_movimiento_inventario', function (Blueprint $table) {

            $table->integer('id_inventario')->unsigned();
            $table->primary('id_inventario');
            //Relacion de herramienta
            $table->unsignedInteger('id_herramienta');
            $table->foreign('id_herramienta')->references('id_herramienta')->on('cnth_herramientas');
            //Relacion de almacen
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes');
            //Tablas 
            $table->string('movimiento',50)->nullable();
            $table->string('tipo_movimiento',50)->nullable();
            $table->string('descripcion',100)->nullable();
            $table->string('usuario', 50)->nullable();
            $table->integer('entrada')->nullable();
            $table->dateTime('fecha')->nullable();
            $table->integer('salida')->nullable();
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
        Schema::dropIfExists('cnth_movimiento_inventario');
    }
};
