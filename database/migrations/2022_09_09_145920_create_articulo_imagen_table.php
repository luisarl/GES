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
        Schema::create('articulo_imagen', function (Blueprint $table) {
            
            $table->integer('id_articulo_imagen')->unsigned();
            $table->primary('id_articulo_imagen');
            $table->unsignedInteger('id_articulo');
            $table->foreign('id_articulo')->references('id_articulo')->on('articulos');
            $table->string('imagen',150)->nullable();
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
        Schema::dropIfExists('articulo_imagen');
    }
};
