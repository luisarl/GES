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
        Schema::create('articulo_clasificacion', function (Blueprint $table) {
           
            $table->integer('id_articulo_clasificacion')->unsigned();
            $table->primary('id_articulo_clasificacion');
            //Relacion de articulo
            $table->unsignedInteger('id_articulo');
            $table->foreign('id_articulo')->references('id_articulo')->on('articulos');
            //Relacion de Clasificacion
            $table->unsignedInteger('id_clasificacion');
            $table->foreign('id_clasificacion')->references('id_clasificacion')->on('clasificaciones');
            //Llave foranea de subclasificacion
            $table->unsignedInteger('id_subclasificacion');
            $table->foreign('id_subclasificacion')->references('id_subclasificacion')->on('subclasificaciones')->onUpdate('no action');
           
            // columna normales
            $table->text('valor');
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
        Schema::dropIfExists('articulo_clasificacion');
    }
};
