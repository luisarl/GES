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
        Schema::create('articulo_ubicacion', function (Blueprint $table)
        {
            $table->integer('id_articulo_ubicacion')->unsigned();
            $table->primary('id_articulo_ubicacion');
            //Relacion de articulo
            $table->unsignedInteger('id_articulo');
            $table->foreign('id_articulo')->references('id_articulo')->on('articulos');
            //Relacion de Almacen
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes')->onUpdate('cascade'); //->onDelete('cascade')
            //Relacion de subalmacen
            $table->unsignedInteger('id_subalmacen');
            $table->foreign('id_subalmacen')->references('id_subalmacen')->on('subalmacenes');
            //Tablas 
            $table->unsignedInteger('id_ubicacion');
            $table->foreign('id_ubicacion')->references('id_ubicacion')->on('ubicaciones');
            
            $table->string('zona')->nullable();
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
        Schema::dropIfExists('articulo_ubicacion');
    }
};
