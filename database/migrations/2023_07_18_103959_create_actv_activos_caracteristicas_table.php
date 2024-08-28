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
        Schema::create('actv_activos_caracteristicas', function (Blueprint $table) {
            $table->integer('id_activo_caracteristica')->unsigned();
            $table->primary('id_activo_caracteristica');
            $table->string('valor_caracteristica',150)->nullable();
            //Relacion de activos
            $table->unsignedInteger('id_activo');
            $table->foreign('id_activo')->references('id_activo')->on('actv_activos');
            //Relacion a caracteristicas
            $table->unsignedInteger('id_caracteristica');
            $table->foreign('id_caracteristica')->references('id_caracteristica')->on('actv_caracteristicas');
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
        Schema::dropIfExists('actv_activos_caracteristicas');
    }
};
