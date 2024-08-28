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
        Schema::create('cenc_tablas_consumo', function (Blueprint $table) {
            $table->integer('id_tabla_consumo')->primary();
            $table->integer('id_equipo_consumible');
            $table->float('espesor', 0, 0);
            $table->string('valor', 50);
            $table->timestamps();
            $table->foreign(['id_equipo_consumible'], 'FK__cenc_tabl__id_eq__4FF1D159')->references(['id_equipo_consumible'])->on('cenc_equipos_consumibles')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_tablas_consumo');
        Schema::table('cenc_tablas_consumo', function (Blueprint $table) {
            $table->dropForeign('FK__cenc_tabl__id_eq__4FF1D159');
        });
    }
};
