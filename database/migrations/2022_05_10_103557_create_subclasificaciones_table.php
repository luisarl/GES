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
        Schema::create('subclasificaciones', function (Blueprint $table) {
            $table->integer('id_subclasificacion')->unsigned();
            $table->primary('id_subclasificacion');
            $table->string('nombre_subclasificacion',50);
            $table->char('visible_fict', 2)->nullable();
            //Tablas con relacion a clasificacion
            $table->unsignedInteger('id_clasificacion');
            $table->foreign('id_clasificacion')->references('id_clasificacion')->on('clasificaciones')->onUpdate('cascade'); //->onDelete('cascade')
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
        Schema::dropIfExists('subclasificaciones');
    }
};
