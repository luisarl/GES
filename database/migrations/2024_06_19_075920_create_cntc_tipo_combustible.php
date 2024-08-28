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
        Schema::create('cntc_tipo_combustible', function (Blueprint $table) {
            $table->integer('id_tipo_combustible')->primary();
            $table->string('descripcion_combustible');
            $table->integer('id_departamento_encargado');
            $table->float('stock');
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
        Schema::dropIfExists('cntc_tipo_combustible');
    }
};
