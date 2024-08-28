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
        Schema::create('actv_caracteristicas', function (Blueprint $table) {
            $table->integer('id_caracteristica')->unsigned();
            $table->primary('id_caracteristica');
            $table->text('nombre_caracteristica',150);
            //Tablas con relacion a tipos
            $table->unsignedInteger('id_tipo');
            $table->foreign('id_tipo')->references('id_tipo')->on('actv_tipos')->onUpdate('cascade'); //->onDelete('cascade')
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
        Schema::dropIfExists('actv_caracteristicas');
    }
};
