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
        Schema::create('almacenes', function (Blueprint $table) {
            $table->integer('id_almacen')->unsigned();
            $table->primary('id_almacen');
            $table->string('nombre_almacen',150);
            $table->string('empresa_almacen',150);
            $table->string('responsable',100)->nullable();
            $table->string('correo',255)->nullable();
            $table->string('superior',100)->nullable();
            $table->string('correo2',255)->nullable();
            $table->string('bd_almacen',150);
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
        Schema::dropIfExists('almacenes');
    }
};
