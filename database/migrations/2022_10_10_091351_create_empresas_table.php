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
        Schema::create('empresas', function (Blueprint $table) {
            $table->integer('id_empresa');
            $table->primary('id_empresa');
            $table->string('nombre_empresa',200);
            $table->string('direccion',250)->nullable();
            $table->string('rif',50)->nullable();
            $table->string('presidente',50)->nullable();
            $table->string('correo_presidente',100)->nullable();
            $table->string('base_datos',50)->nullable();
            $table->char('visible_ficht', 2)->nullable();
            $table->string('alias_empresa',150)->nullable();
            $table->string('responsable_almacen',50)->nullable();
            $table->string('correo_responsable',100)->nullable();
            $table->string('superior_almacen',50)->nullable();
            $table->string('correo_superior',100)->nullable();
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
        Schema::dropIfExists('empresas');
    }
};
