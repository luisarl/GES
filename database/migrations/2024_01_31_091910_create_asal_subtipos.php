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
        Schema::create('asal_subtipos', function (Blueprint $table) {
            $table->integer('id_subtipo')->unsigned();
            $table->primary('id_subtipo');
            $table->unsignedInteger('id_tipo');
            $table->foreign('id_tipo')->references('id_tipo')->on('asal_tipos')->onUpdate('cascade');
            $table->string('nombre_subtipo',150);
            $table->string('descripcion_subtipo',300);
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
        Schema::dropIfExists('asal_subtipos');
    }
};
