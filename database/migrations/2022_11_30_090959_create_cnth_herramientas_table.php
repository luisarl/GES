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
        Schema::create('cnth_herramientas', function (Blueprint $table) {
            $table->integer('id_herramienta')->unsigned();
            $table->primary('id_herramienta');
            $table->string('codigo_herramienta')->nullable();
            $table->string('correlativo',10)->nullable();
            // $table->integer('stock');
            $table->string('nombre_herramienta',150);
            $table->text('descripcion_herramienta')->nullable();
            $table->string('imagen_herramienta',50)->nullable();
            $table->string('creado_por',100)->nullable();
            $table->string('actualizado_por',100)->nullable();
            //Inicio de las llaves foraneas
            //Llave foranea de grupo
            $table->unsignedInteger('id_grupo')->nullable();
            $table->foreign('id_grupo')->references('id_grupo')->on('cnth_grupos')->onUpdate('no action')->onDelete('no action');
            //Llave foranea de subgrupo
            $table->unsignedInteger('id_subgrupo');
            $table->foreign('id_subgrupo')->references('id_subgrupo')->on('cnth_subgrupos');
            //Llave foranea de categoria
            $table->unsignedInteger('id_categoria');
            $table->foreign('id_categoria')->references('id_categoria')->on('cnth_categorias')->onUpdate('cascade');
            // //Llave foranea de categoria
            // $table->unsignedInteger('id_ubicacion');
            // $table->foreign('id_ubicacion')->references('id_ubicacion')->on('cnth_ubicaciones')->onUpdate('cascade');
            // //Llave foranea de categoria
            // $table->unsignedInteger('id_almacen');
            // $table->foreign('id_almacen')->references('id_almacen')->on('almacenes');
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
        Schema::dropIfExists('cnth_herramientas');
    }
};
