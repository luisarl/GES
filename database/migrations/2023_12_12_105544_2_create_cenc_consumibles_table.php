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
        Schema::create('cenc_consumibles', function (Blueprint $table) {
            $table->integer('id_consumible')->primary();
            $table->string('nombre_consumible', 100);
            $table->string('descripcion_consumible', 200)->nullable();
            $table->string('unidad_consumible', 50)->nullable();
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
        Schema::dropIfExists('cenc_consumibles');
    }
};
