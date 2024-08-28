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
        Schema::create('asal_tipos', function (Blueprint $table) {
            $table->integer('id_tipo')->unsigned();
            $table->primary('id_tipo');
            $table->string('nombre_tipo',150);
            $table->string('descripcion_tipo',300);
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
        Schema::dropIfExists('asal_tipos');
    }
};
