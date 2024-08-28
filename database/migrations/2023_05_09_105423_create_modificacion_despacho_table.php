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
        Schema::table('cnth_movimientos', function (Blueprint $table) {
            $table->string('responsable')->nullable();
        });
        Schema::table('cnth_movimientos_detalles', function (Blueprint $table) {
            $table->string('recibido_por',50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modificacion_despacho');
    }
};
