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
        Schema::create('cenc_equipos_consumibles', function (Blueprint $table) {
            $table->integer('id_equipo_consumible')->primary();
            $table->integer('id_consumible');
            $table->integer('id_equipotecnologia');
            $table->timestamps();
            $table->foreign(['id_consumible'], 'FK__cenc_equi__id_co__4C214075')->references(['id_consumible'])->on('cenc_consumibles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['id_equipotecnologia'], 'FK__cenc_equi__id_eq__4D1564AE')->references(['id_equipotecnologia'])->on('cenc_equipos_tecnologias')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_equipos_consumibles');
        Schema::table('cenc_equipos_consumibles', function (Blueprint $table) {
            $table->dropForeign('FK__cenc_equi__id_co__4C214075');
            $table->dropForeign('FK__cenc_equi__id_eq__4D1564AE');
        });
    }
};
