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
        Schema::create('cnth_salidas', function (Blueprint $table) {
            $table->integer('id_salida')->unsigned();
            $table->primary('id_salida');
            //Relacion de almacen
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes');
            //Tablas 
            $table->string('motivo',50)->nullable();
            $table->string('descripcion',100)->nullable();
            $table->string('usuario', 50)->nullable();
            $table->dateTime('fecha')->nullable();
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
        Schema::dropIfExists('cnth_salidas');
    }
};
