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
        Schema::create('embarcaciones_usuarios', function (Blueprint $table) {
            $table->integer('id_embarcaciones_usuario')->primary();
            $table->integer('id_embarcaciones');
            $table->bigInteger('id_usuario');
            $table->timestamps();
            $table->foreign('id_embarcaciones')->references('id_embarcaciones')->on('emba_embarcaciones');
            $table->foreign('id_usuario')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('embarcaciones_usuarios');
    }
};
