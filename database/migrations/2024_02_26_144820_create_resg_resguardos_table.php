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
        Schema::create('resg_resguardos', function (Blueprint $table) {
            $table->integer('id_resguardo')->unsigned();
            $table->primary('id_resguardo');
            $table->unsignedInteger('id_solicitud_resguardo');
            $table->foreign('id_solicitud_resguardo')->references('id_solicitud_resguardo')->on('resg_solicitudes_resguardo')->onUpdate('cascade');
            $table->string('codigo_articulo', 100);
            $table->string('nombre_articulo', 300);
            $table->string('tipo_unidad', 100);
            $table->float('cantidad');
            $table->string('estado', 50);
            $table->text('observacion')->nullable();
            $table->unsignedInteger('id_clasificacion');
            $table->foreign('id_clasificacion')->references('id_clasificacion')->on('resg_clasificaciones');
            $table->unsignedInteger('id_ubicacion')->nullable();
            $table->foreign('id_ubicacion')->references('id_ubicacion')->on('resg_ubicaciones');
            $table->string('estatus', 50)->nullable();
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
        Schema::dropIfExists('resg_resguardos');
    }
};
