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
        Schema::create('cenc_equipos_tecnologias', function (Blueprint $table) {
            $table->integer('id_equipotecnologia')->primary();
            $table->integer('id_equipo');
            $table->integer('id_tecnologia')->nullable();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->foreign(['id_equipo'], 'FK__cenc_equi__id_eq__15C52FC4')->references(['id_equipo'])->on('cenc_equipos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['id_tecnologia'], 'FK__cenc_equi__id_te__17AD7836')->references(['id_tecnologia'])->on('cenc_tecnologias')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_equipos_tecnologias');
        Schema::table('cenc_equipos_tecnologias', function (Blueprint $table) {
            $table->dropForeign('FK__cenc_equi__id_eq__15C52FC4');
            $table->dropForeign('FK__cenc_equi__id_te__17AD7836');
        });
    }
};
