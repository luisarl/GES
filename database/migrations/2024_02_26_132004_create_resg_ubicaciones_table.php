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
        Schema::create('resg_ubicaciones', function (Blueprint $table) {
            $table->integer('id_ubicacion')->unsigned();
            $table->primary('id_ubicacion');
            $table->string('nombre_ubicacion',150);
            $table->string('descripcion_ubicacion',300)->nullable();
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes')->onUpdate('cascade');
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
        Schema::dropIfExists('resg_ubicaciones');
    }
};
