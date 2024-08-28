<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('audi_auditoria_inventario', function (Blueprint $table) {
            $table->integer('id_auditoria_inventario')->primary();
            $table->unsignedInteger('id_articulo');
            $table->foreign('id_articulo')->references('id_articulo')->on('articulos');
            $table->string('codigo_articulo', '50')->nullable();
            $table->unsignedInteger('id_almacen');
            $table->foreign('id_almacen')->references('id_almacen')->on('almacenes');
            $table->unsignedInteger('id_subalmacen');
            $table->foreign('id_subalmacen')->references('id_subalmacen')->on('subalmacenes');
            $table->float('stock_actual');
            $table->float('conteo_fisico');
            $table->integer('numero_auditoria');
            $table->text('observacion')->nullable();
            $table->string('fotografia', 150)->nullable();
            $table->dateTime('fecha');
            $table->string('usuario');
            $table->ipAddress('direccion_ip');
            $table->string('nombre_equipo', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audi_auditoria_inventario');
    }
};
