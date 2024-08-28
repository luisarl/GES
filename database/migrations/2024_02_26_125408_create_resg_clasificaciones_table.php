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
        Schema::create('resg_clasificaciones', function (Blueprint $table) {
            $table->integer('id_clasificacion')->unsigned();
            $table->primary('id_clasificacion');
            $table->string('nombre_clasificacion',150);
            $table->string('descripcion_clasificacion',300)->nullable();
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
        Schema::dropIfExists('resg_clasificaciones');
    }
};
