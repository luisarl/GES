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
        Schema::create('cnth_movimientos_detalles', function (Blueprint $table) {
            
            $table->integer('id_detalle')->unsigned();
            $table->primary('id_detalle');
            //Relacion de herramienta
            $table->unsignedInteger('id_herramienta');
            $table->foreign('id_herramienta')->references('id_herramienta')->on('cnth_herramientas');
            //Relacion de movimiento
            $table->unsignedInteger('id_movimiento');
            $table->foreign('id_movimiento')->references('id_movimiento')->on('cnth_movimientos');
            //Llave foranea de empleado
            $table->unsignedInteger('id_empleado')->nullable();
            $table->foreign('id_empleado')->references('id_empleado')->on('cnth_empleados')->nullable();
            //Tablas 
            $table->string('responsable',150)->nullable();
            $table->string('nombre_solicitante')->nullable();
            $table->integer('cantidad_entregada')->nullable();
            $table->integer('cantidad_devuelta')->nullable();
            $table->char('aprobacion',2)->nullable();
            $table->dateTime('fecha_despacho')->nullable();
            $table->dateTime('fecha_devolucion')->nullable();
            $table->string('estatus',50)->nullable();
            $table->string('eventualidad')->nullable();
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
        Schema::dropIfExists('cnth_movimientos_detalles');
    }
};
