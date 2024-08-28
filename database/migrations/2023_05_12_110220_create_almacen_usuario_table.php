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
        Schema::create('almacen_usuario', function (Blueprint $table) {
                       
            $table->integer('id_almacen_usuario')->unsigned();
            $table->primary('id_almacen_usuario');
            //Relacion de almacen
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes');
            //Relacion de usuarios
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('users');
            //Llave foranea de empresa
            $table->unsignedInteger('id_empresa');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresas')->onUpdate('no action');
           
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
        Schema::dropIfExists('almacen_usuario');
    }
};
