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
        Schema::create('cenc_fichas_caracteristicas', function (Blueprint $table) {
            $table->integer('id_caracteristica')->primary();
            $table->string('nombre_caracteristica', 150);
            $table->integer('id_tipo');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->foreign(['id_tipo'], 'FK__cenc_fich__id_ti__231F2AE2')->references(['id_tipo'])->on('cenc_fichas_tipos')->onUpdate('NO ACTION')->onDelete('NO ACTION');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_fichas_caracteristicas');
        Schema::table('cenc_fichas_caracteristicas', function (Blueprint $table) {
            $table->dropForeign('FK__cenc_fich__id_ti__231F2AE2');
        });
    }
};
