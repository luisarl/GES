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
        Schema::create('comp_proveedores_empresas', function (Blueprint $table) {
            $table->integer('id_proveedor_empresa');
            $table->primary('id_proveedor_empresa');
            $table->char('solicitado',2)->nullable();
            $table->string('usuario_solicitante', 100)->nullable();
            $table->char('migrado',2)->nullable();
            $table->string('usuario_migracion',100)->nullable();
            $table->dateTime('fecha_solicitud')->nullable();
            $table->dateTime('fecha_migracion')->nullable();
            //Inicio de las llaves foraneas
            //llave foranea de tabla empresa
            $table->unsignedInteger('id_empresa');
            $table->foreign('id_empresa')->references('id_empresa')->on('empresas')->onUpdate('cascade');
            //llave foranea de tabla proveedor
            $table->unsignedInteger('id_proveedor');
            $table->foreign('id_proveedor')->references('id_proveedor')->on('comp_proveedores')->onUpdate('cascade');
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
        Schema::dropIfExists('comp_proveedores_empresas');
    }
};
