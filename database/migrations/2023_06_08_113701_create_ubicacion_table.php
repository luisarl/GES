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

        Schema::create('ubicaciones', function (Blueprint $table) {
            $table->integer('id_ubicacion')->unsigned();
            $table->primary('id_ubicacion');
            $table->string('nombre_ubicacion',50);
            $table->string('codigo_ubicacion',50)->nullable();
            $table->string('creado_por',50)->nullable();
            $table->string('actualizado_por',50)->nullable();
            //llave foranea de tabla almacen
            $table->unsignedInteger('id_subalmacen');
            $table->foreign('id_subalmacen')->references('id_subalmacen')->on('subalmacenes')->onUpdate('cascade');
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
        Schema::dropIfExists('ubicaciones');
    }
};
