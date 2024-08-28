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
        Schema::create('gsta_horarios', function (Blueprint $table) {
            $table->integer('id_horario')->primary();
            $table->string('nombre_horario',150);
            $table->time('inicio_jornada');
            $table->time('fin_jornada');
            $table->time('inicio_descanso');
            $table->time('fin_descanso');
            $table->string('dias_seleccionados',255);
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
        Schema::dropIfExists('gsta_horarios');
    }
};
