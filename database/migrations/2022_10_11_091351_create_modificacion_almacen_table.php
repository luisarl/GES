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
        Schema::table('almacenes', function (Blueprint $table) {
            $table->dropColumn(array('bd_almacen', 'empresa_almacen'));
            $table->char('visible_ficht', 2)->nullable();
            $table->char('visible_cnth', 2)->nullable();
            //Columnas con relacion a empresas
            $table->unsignedInteger('id_empresa')->nullable();
            $table->foreign('id_empresa')->references('id_empresa')->on('empresas')->onUpdate('cascade'); //->onDelete('cascade')

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modificacion_almacen');
    }
};
