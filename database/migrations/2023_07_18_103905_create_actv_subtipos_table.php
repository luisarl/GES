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
        Schema::create('actv_subtipos', function (Blueprint $table) {
            $table->integer('id_subtipo')->unsigned();
            $table->primary('id_subtipo');
            $table->text('nombre_subtipo',150);
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
        Schema::dropIfExists('actv_subtipos');
    }
};
