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
        Schema::create('resg_solicitudes_despacho_detalle', function (Blueprint $table) {
            $table->integer('id_solicitud_despacho_detalle')->unsigned();
            $table->primary('id_solicitud_despacho_detalle');
            $table->unsignedInteger('id_solicitud_despacho');
            $table->foreign('id_solicitud_despacho')->references('id_solicitud_despacho')->on('resg_solicitudes_despacho');
            $table->unsignedInteger('id_resguardo');
            $table->foreign('id_resguardo')->references('id_resguardo')->on('resg_resguardos');
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
        Schema::dropIfExists('resg_solicitudes_despacho_detalle');
    }
};
