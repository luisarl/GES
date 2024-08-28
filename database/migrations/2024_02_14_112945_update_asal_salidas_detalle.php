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
        Schema::table('asal_salidas_detalle', function (Blueprint $table) {
            $table->string('usuario_cierre', 100)->nullable();
            $table->dateTime('fecha_cierre')->nullable(); 
            $table->text('cerrado', 2)->nullable(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
