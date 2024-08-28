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
        Schema::create('asal_vehiculos', function (Blueprint $table) {
            $table->integer('id_vehiculo')->unsigned();
            $table->primary('id_vehiculo');
            $table->char('activo', 2)->nullable();
            $table->string('imagen_vehiculo',50)->nullable();
            $table->string('placa_vehiculo',20)->nullable();
            $table->string('marca_vehiculo',150);
            $table->string('modelo_vehiculo',150)->nullable();
            $table->text('descripcion')->nullable();
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
        Schema::dropIfExists('asal_vehiculos');
    }
};
