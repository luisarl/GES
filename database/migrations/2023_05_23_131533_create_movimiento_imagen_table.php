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
        Schema::create('cnth_movimiento_imagen', function (Blueprint $table) {
            $table->integer('id_movimiento_imagen')->unsigned();
            $table->primary('id_movimiento_imagen');
            $table->unsignedInteger('id_movimiento');
            $table->foreign('id_movimiento')->references('id_movimiento')->on('cnth_movimientos');
            $table->string('imagen',150)->nullable();
            $table->string('tipo',50)->nullable();
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
        Schema::dropIfExists('movimiento_imagen');
    }
};
