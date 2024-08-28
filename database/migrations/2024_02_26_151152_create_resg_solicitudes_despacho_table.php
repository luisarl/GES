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
        Schema::create('resg_solicitudes_despacho', function (Blueprint $table) {
            $table->integer('id_solicitud_despacho')->unsigned();
            $table->primary('id_solicitud_despacho');
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes')->onUpdate('cascade');
            $table->string('ubicacion_destino', 200);
            $table->text('observacion');
            $table->string('estatus', 50);
            $table->unsignedInteger('id_departamento');
            $table->foreign('id_departamento')->references('id_departamento')->on('departamentos')->onUpdate('cascade');
            $table->string('creado_por', 100)->nullable();
            $table->dateTime('fecha_creacion')->nullable();
            $table->string('actualizado_por', 100)->nullable();
            $table->dateTime('fecha_actualizacion')->nullable();
            $table->string('aprobado_por', 100)->nullable();
            $table->dateTime('fecha_aprobacion')->nullable();
            $table->string('procesado_por', 100)->nullable();
            $table->dateTime('fecha_procesado')->nullable();
            $table->string('anulado_por', 100)->nullable();
            $table->dateTime('fecha_anulacion')->nullable();
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
        Schema::dropIfExists('resg_solicitudes_despacho');
    }
};
