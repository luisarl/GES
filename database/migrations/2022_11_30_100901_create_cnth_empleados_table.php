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
        Schema::create('cnth_empleados', function (Blueprint $table) {
            $table->integer('id_empleado')->unsigned();
            $table->primary('id_empleado');
            $table->string('nombre_empleado')->nullable();
            $table->char('estatus', 2)->nullable();
            //Relacion con departamento
            $table->unsignedInteger('id_departamento');
            $table->foreign('id_departamento')->references('id_departamento')->on('departamentos');
            
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
        Schema::dropIfExists('cnth_empleados');
    }
};
