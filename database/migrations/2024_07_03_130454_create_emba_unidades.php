<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('emba_unidades', function (Blueprint $table) {
            $table->integer('id_unidad')->unsigned();
            $table->primary('id_unidad');
            $table->string('nombre_unidad', 100);
            $table->string('descripcion_unidad', 150);
            $table->string('abreviatura', 10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emba_unidades');
    }
};
