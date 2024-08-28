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
        Schema::create('gsta_validaciones_asistencias', function (Blueprint $table) {
            $table->integer('id_validacion')->primary();
            $table->string('id_empleado');
            $table->integer('id_biometrico');
            $table->date('fecha_validacion');
            $table->string('nombre_empleado');
            $table->time('hora_entrada');
            $table->time('hora_salida');
            $table->string('id_departamento');
            $table->string('nombre_empresa');
            $table->string('id_empresa');
            $table->string('observacion',250);
            $table->string('estatus',50);
            $table->string('creado_por',150);
            $table->datetime('fecha_creacion');
            $table->string('actualizado_por',150)->nullable();
            $table->datetime('fecha_actualizacion')->nullable();
            $table->string('direccion_ip',300);
            $table->string('nombre_equipo',300);
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
        Schema::dropIfExists('gsta_validaciones_asistencias');
    }
};
