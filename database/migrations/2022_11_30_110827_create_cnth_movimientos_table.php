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
        Schema::create('cnth_movimientos', function (Blueprint $table) {
            $table->integer('id_movimiento')->unsigned();
            $table->primary('id_movimiento');
            $table->integer('numero_solicitud')->nullable();
            $table->string('motivo')->nullable();
            $table->string('imagen')->nullable();
            $table->string('estatus')->nullable();
            $table->string('creado_por',50)->nullable();
            //Llave foranea de empleado
            $table->unsignedInteger('id_empleado');
            $table->foreign('id_empleado')->references('id_empleado')->on('cnth_empleados');
            //Llave foranea de almacen
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes');
            //Relacion de zonas
            $table->unsignedInteger('id_zona');
            $table->foreign('id_zona')->references('id_zona')->on('cnth_zonas');
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
        Schema::dropIfExists('cnth_movimientos');
    }
};
