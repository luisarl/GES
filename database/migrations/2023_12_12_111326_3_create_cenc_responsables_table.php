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
        Schema::create('cenc_responsables', function (Blueprint $table) {
            $table->integer('id_responsable');
            $table->integer('id_departamento');
            $table->string('nombre_responsable', 150);
            $table->string('cargo_responsable', 200)->nullable();
            $table->string('correo', 150)->nullable();
            $table->char('estatus', 2);
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
        Schema::dropIfExists('cenc_responsables');
    }
};
