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
        Schema::create('articulo_migracion', function (Blueprint $table) {
            
            //Relacion de articulo
            $table->unsignedInteger('id_articulo');
            $table->foreign('id_articulo')->references('id_articulo')->on('articulos');
            //Relacion de Almacen
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes');
            //Tablas 
            $table->string('nombre_usuario',50)->nullable();
            $table->string('nombre_solicitante')->nullable();
            $table->char('migrado',3)->nullable();
            $table->char('solicitado',3)->nullable();
            $table->string('fecha_solicitud')->nullable();
            $table->string('nombre_equipo',50)->nullable();
            $table->string('direccion_ip',50)->nullable();
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
        Schema::dropIfExists('articulo_migracion');
    }
};
