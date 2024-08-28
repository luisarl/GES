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
        Schema::create('cenc_fichas', function (Blueprint $table) {
            $table->integer('id_ficha')->primary();
            $table->string('codigo_ficha', 50);
            $table->string('nombre_ficha', 50);
            $table->string('descripcion_ficha', 200);
            $table->integer('id_tipo');
            $table->timestamps();
            $table->foreign(['id_tipo'], 'FK__cenc_fich__id_ti__25FB978D')->references(['id_tipo'])->on('cenc_fichas_tipos')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_fichas');
        Schema::table('cenc_fichas', function (Blueprint $table) {
            $table->dropForeign('FK__cenc_fich__id_ti__25FB978D');
        });
    }
};
