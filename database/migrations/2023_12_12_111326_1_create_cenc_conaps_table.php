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
        Schema::create('cenc_conaps', function (Blueprint $table) {
            $table->integer('id_conap')->primary();
            $table->integer('nro_conap');
            $table->string('nombre_conap', 100);
            $table->text('descripcion_conap')->nullable();
            $table->timestamps();
            $table->string('estatus_conap', 50)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cenc_conaps');
    }
};
