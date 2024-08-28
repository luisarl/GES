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
        Schema::create('subalmacenes', function (Blueprint $table) {
            $table->integer('id_subalmacen')->unsigned();
            $table->primary('id_subalmacen');
            $table->string('nombre_subalmacen',50);
            $table->text('descripcion_subalmacen',250);
            $table->string('codigo_subalmacen',50)->nullable();
            $table->string('creado_por',50)->nullable();
            $table->string('actualizado_por',50)->nullable();
            //Tablas con relacion a almacenes
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes')->onUpdate('cascade'); //->onDelete('cascade')
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
        Schema::dropIfExists('subalmacenes');
    }
};
