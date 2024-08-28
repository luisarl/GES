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
        Schema::create('articulos', function (Blueprint $table) {
            $table->integer('id_articulo')->unsigned();
            $table->primary('id_articulo');
            $table->string('codigo_articulo')->nullable();
            $table->string('estatus')->nullable()->default('NO MIGRADO');
            $table->string('correlativo',10)->nullable();
            $table->string('referencia')->nullable();
            $table->string('nombre_articulo',150);
            $table->text('descripcion_articulo')->nullable();
            $table->string('imagen_articulo',50)->nullable();
            $table->string('documento_articulo',50)->nullable();
            $table->integer('pntominimo_articulo');
            $table->integer('pntomaximo_articulo');
            $table->integer('pntopedido_articulo');
            $table->char('activo', 3)->nullable();
            $table->string('id_color',1500)->nullable()->default('000000');
            $table->string('id_proveedor',1500)->nullable()->default('000000000');
            $table->string('id_procedencia',1500)->nullable()->default('000000');
            $table->string('id_tipo',100)->nullable()->default('V');
            $table->integer('id_impuesto')->nullable()->default(1);
            //Inicio de las llaves foraneas
            //Llave foranea de subgrupo
            $table->unsignedInteger('id_subgrupo');
            $table->foreign('id_subgrupo')->references('id_subgrupo')->on('subgrupos')->onUpdate('cascade');
            //Llave foranea de grupo
            $table->unsignedInteger('id_grupo')->nullable();
            $table->foreign('id_grupo')->references('id_grupo')->on('grupos')->onUpdate('no action')->onDelete('no action');
            //Llave foranea de categoria
            $table->unsignedInteger('id_categoria');
            $table->foreign('id_categoria')->references('id_categoria')->on('categorias')->onUpdate('cascade');
            //Llave foranea de unidades
            $table->unsignedInteger('id_unidad');
            $table->foreign('id_unidad')->references('id_unidad')->on('unidades')->onUpdate('cascade')->onDelete('no action');
            //Llave foranea de unidades secundarias
            $table->unsignedInteger('id_unidad_sec');
            $table->foreign('id_unidad_sec')->references('id_unidad')->on('unidades')->onUpdate('no action');
                       
            //Final de las llaves foraneas
            $table->integer('id_unidad_ter')->nullable();
            $table->string('tipo_unidad')->nullable();
            $table->decimal('equi_unid_pri', 18, 5)->nullable()->default(0);
            $table->decimal('equi_unid_sec', 18, 5)->nullable()->default(0);
            $table->decimal('equi_unid_ter', 18, 5)->nullable()->default(0);
            $table->string('creado_por',100)->nullable();
            $table->string('actualizado_por',100)->nullable();
            $table->string('catalogado_por',100)->nullable();
            $table->string('aprobado_por',100)->nullable();
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
        Schema::dropIfExists('articulos');
    }
};
