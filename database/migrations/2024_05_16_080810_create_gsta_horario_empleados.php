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
        Schema::create('gsta_horario_empleados', function (Blueprint $table) {
            $table->integer('id_horario_empleado')->primary();
            $table->string('id_empleado');
            $table->integer('id_biometrico');
            $table->integer('id_horario');
            $table->timestamps();
            $table->foreign('id_horario')->references('id_horario')->on('gsta_horarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gsta_horario_empleados');
    }
};
