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
        Schema::create('actv_activos', function (Blueprint $table) {
            $table->integer('id_activo')->unsigned();
            $table->primary('id_activo');
            $table->string('nombre_activo',100)->nullable();
            $table->string('descripcion_activo',100)->nullable();
            $table->string('codigo_activo',100)->nullable();
            $table->string('imagen_activo',50)->nullable();
            $table->string('marca',100)->nullable();
            $table->string('modelo',100)->nullable();
            $table->string('serial',100)->nullable();
            $table->string('ubicacion',100)->nullable();
            //Tablas con relacion a tipos
            $table->unsignedInteger('id_tipo');
            $table->foreign('id_tipo')->references('id_tipo')->on('actv_tipos')->onUpdate('cascade'); //->onDelete('cascade')
            //relacion entre departamentos y activos
            $table->unsignedInteger('id_departamento')->nullable();
            $table->foreign('id_departamento')->references('id_departamento')->on('departamentos')->onUpdate('cascade'); //
            //Tablas con relacion a subtipos
            $table->unsignedInteger('id_subtipo');
            $table->foreign('id_subtipo')->references('id_subtipo')->on('actv_subtipos');
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
        Schema::dropIfExists('actv_activos');
    }
};
