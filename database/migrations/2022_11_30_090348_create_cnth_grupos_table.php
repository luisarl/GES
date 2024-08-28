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
        Schema::create('cnth_grupos', function (Blueprint $table) {
            $table->integer('id_grupo')->unsigned();
            $table->primary('id_grupo');
            $table->string('nombre_grupo',50);
            $table->string('descripcion_grupo',150);
            $table->string('codigo_grupo',50)->nullable();
            $table->string('creado_por',50)->nullable();
            $table->string('actualizado_por',50)->nullable();
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
        Schema::dropIfExists('cnth_grupos');
    }
};
