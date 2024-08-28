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
        Schema::create('comp_proveedores', function (Blueprint $table) {
            $table->integer('id_proveedor');
            $table->primary('id_proveedor');
            $table->string('codigo_proveedor',50);
            $table->string('nombre_proveedor',200);
            $table->char('nit',20)->nullable();
            $table->string('rif',20)->nullable();
            $table->string('correo',100)->nullable();
            $table->char('activo',2)->nullable();
            $table->string('direccion')->nullable();
            $table->string('responsable',50)->nullable();
            $table->char('nacional',2)->nullable();
            $table->string('ciudad',100)->nullable();
            $table->char('codigo_postal',10);
            $table->string('telefonos',100)->nullable();
            $table->string('website',60)->nullable();
            $table->char('ruc',2)->nullable();
            $table->char('lae',2)->nullable();
            $table->string('estatus', 30)->nullable();
            $table->string('pago1')->nullable();
            $table->string('pago2')->nullable();
            $table->string('pago3')->nullable();
            $table->string('pago4')->nullable();
            $table->char('codigo_actividad',10)->nullable();
            $table->integer('tipo_persona');
            $table->char('cont_especial',10)->nullable();
            $table->integer('porc_retencion');
            $table->string('comentario')->nullable();
            $table->string('creado_por',50)->nullable();
            $table->string('actualizado_por',50)->nullable();
            //Inicio de las llaves foraneas
            //llave foranea de tabla Comp_tipo_proveedor
            $table->char('id_tipo',6);
            $table->foreign('id_tipo')->references('id_tipo')->on('comp_tipo_proveedor')->onUpdate('cascade');
            //llave foranea de tabla Comp_segmento_proveedor
            $table->char('id_segmento',10);
            $table->foreign('id_segmento')->references('id_segmento')->on('comp_segmento_proveedor')->onUpdate('cascade');
            //llave foranea de tabla Zona
            $table->char('id_zona',6);
            $table->foreign('id_zona')->references('id_zona')->on('comp_zonas')->onUpdate('cascade');
            //llave foranea de tabla pais
            $table->char('id_pais',6);
            $table->foreign('id_pais')->references('id_pais')->on('paises')->onUpdate('cascade');
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
        Schema::dropIfExists('comp_proveedor');
    }
};
