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
        Schema::create('cntt_reemplazo_toner', function (Blueprint $table) {
            $table->integer('id_reemplazo_toner')->primary();
            $table->date('fecha_cambio');
            $table->date('fecha_cambio_anterior');
            $table->integer('id_impresora');
            $table->integer('id_departamento');
            $table->string('observacion')->nullable();
            $table->string('tipo_servicio');
            $table->bigInteger('cantidad_hojas_actual');
            $table->bigInteger('cantidad_hojas_anterior');
            $table->bigInteger('cantidad_hojas_total');
            $table->bigInteger('dias_de_duracion');
            $table->string('creado_por');
            $table->timestamps();
            $table->foreign('id_departamento')->references('id_departamento')->on('departamentos');
            $table->foreign('id_impresora')->references('id_activo')->on('actv_activos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cntt_reemplazo_toner');
    }
};
