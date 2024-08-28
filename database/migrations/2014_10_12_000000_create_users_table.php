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

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('email',255)->unique();
            $table->char('activo', 2)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password',255);
            $table->string('username',255);
            $table->rememberToken(100);
            //relacion entre departamentos y usuarios
            $table->unsignedInteger('id_departamento')->nullable();
            $table->foreign('id_departamento')->references('id_departamento')->on('departamentos')->onUpdate('cascade'); //->onDelete('cascade')          
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
        Schema::dropIfExists('users');
    }
};
