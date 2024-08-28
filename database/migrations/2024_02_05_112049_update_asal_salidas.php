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
        Schema::table('asal_salidas', function (Blueprint $table) {
            $table->unsignedInteger('id_tipo')->nullable();
            $table->foreign('id_tipo')->references('id_tipo')->on('asal_tipos');
            $table->unsignedInteger('id_subtipo')->nullable();
            $table->foreign('id_subtipo')->references('id_subtipo')->on('asal_subtipos');
            $table->string('usuario_cierre_almacen', 150)->nullable(); 
            $table->dateTime('fecha_cierre_almacen')->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
