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
        Schema::create('asal_salidas', function (Blueprint $table) {
            $table->integer('id_salida')->unsigned();
            $table->primary('id_salida');
            $table->string('correlativo',10)->nullable();
            $table->text('motivo')->nullable();
            $table->string('estatus')->nullable();
            $table->string('destino',50)->nullable();
            $table->string('solicitante',50)->nullable();
            $table->string('departamento',50)->nullable();
            $table->string('responsable',50)->nullable();
            $table->string('tipo_responsable',50)->nullable();
            $table->string('responsable_foraneo',50)->nullable();
            $table->string('autorizado',50)->nullable();
            $table->string('tipo_salida',10)->nullable();
            $table->string('tipo_conductor',10)->nullable();
            $table->string('tipo_vehiculo',10)->nullable();
            $table->string('conductor',50)->nullable();
            $table->string('vehiculo_foraneo')->nullable();
            $table->string('validado',2)->nullable();
            $table->string('usuario_validacion',20)->nullable();
            $table->dateTime('fecha_validacion')->nullable();
            $table->dateTime('fecha_cierre')->nullable();
            $table->date('fecha_salida')->nullable();
            $table->time('hora_salida')->nullable();
            $table->string('creado_por',100)->nullable();
            $table->string('cerrado_por',100)->nullable();
            $table->string('actualizado_por',100)->nullable();
            $table->string('anulado',100)->nullable();
            $table->string('anulado_por',100)->nullable();
            
            //relacion con almacen
            $table->unsignedInteger('id_almacen')->nullable();
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes')->onUpdate('cascade');
            //relacion con vehiculo
            $table->unsignedInteger('id_vehiculo')->nullable();
            $table->foreign('id_vehiculo')->references('id_vehiculo')->on('asal_vehiculos')->onUpdate('cascade');
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
        Schema::dropIfExists('asal_salidas');
    }
};
