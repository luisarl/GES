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
        Schema::create('unidades', function (Blueprint $table) {
            $table->integer('id_unidad')->unsigned();
            $table->primary('id_unidad');
            $table->string('nombre_unidad',50);
            $table->text('abreviatura_unidad',50);
            $table->text('clasificacion_unidad',50);
            $table->string('creado_por',50)->nullable();
            $table->string('actualizado_por',50)->nullable();
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
        Schema::dropIfExists('unidades');
    }
};
