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
        Schema::create('cnth_responsables_movimientos', function (Blueprint $table) {
            $table->integer('id_responsable_movimiento')->unsigned();;
            $table->primary('id_responsable_movimiento');
            $table->unsignedInteger('id_movimiento');
            $table->foreign('id_movimiento')->references('id_movimiento')->on('cnth_movimientos')->onUpdate('cascade'); ;
            $table->string('responsable', 150);
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
        Schema::dropIfExists('cnth_responsables_movimientos');
    }
};
