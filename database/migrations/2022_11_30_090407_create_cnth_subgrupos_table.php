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
        Schema::create('cnth_subgrupos', function (Blueprint $table) {
            $table->integer('id_subgrupo')->unsigned();
            $table->primary('id_subgrupo');
            $table->string('nombre_subgrupo',50);
            $table->text('descripcion_subgrupo',250);
            $table->string('codigo_subgrupo',50)->nullable();
            $table->string('creado_por',50)->nullable();
            $table->string('actualizado_por',50)->nullable();
            //Tablas con relacion a grupo
            $table->unsignedInteger('id_grupo');
            $table->foreign('id_grupo')->references('id_grupo')->on('cnth_grupos')->onUpdate('cascade'); //->onDelete('cascade')
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
        Schema::dropIfExists('cnth_subgrupos');
    }
};
