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
        Schema::create('cenc_fichas_valores_caracteristicas', function (Blueprint $table) {
            $table->integer('id_ficha_valor')->primary();
            $table->integer('id_ficha')->nullable();
            $table->integer('id_caracteristica')->nullable();
            $table->integer('valor_caracteristica')->nullable();
            $table->timestamps();
            $table->foreign(['id_ficha'], 'FK__cenc_fich__id_fi__28D80438')->references(['id_ficha'])->on('cenc_fichas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['id_caracteristica'], 'FK__cenc_fich__id_ca__29CC2871')->references(['id_caracteristica'])->on('cenc_fichas_caracteristicas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_fichas_valores_caracteristicas');
        Schema::table('cenc_fichas_valores_caracteristicas', function (Blueprint $table) {
            $table->dropForeign('FK__cenc_fich__id_fi__28D80438');
            $table->dropForeign('FK__cenc_fich__id_ca__29CC2871');
        });
    }
};
