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
        Schema::create('empresas', function (Blueprint $table) {
             $table->id('id_empresa');
            $table->string('nombre_comercial', 255);
            $table->string('razon_social', 255);
            $table->string('sector', 100);
            $table->string('estado_inicial', 100);
            $table->string('numero_empleados', 20);
            $table->date('fecha_registro');
            $table->year('ano_mercado');
            $table->string('tipo_organizacion', 100);
            $table->string('image', 255)->nullable();
            $table->string('rfc', 20)->unique();
            $table->string('pais', 100);
            $table->string('estado', 100);
            $table->string('ciudad', 100);
            $table->text('direccion');
            $table->string('codigo_postal', 10);
            $table->string('contacto_nombre', 255);
            $table->string('contacto_puesto', 100);
            $table->string('contacto_telefono', 20);
            $table->string('contacto_correo', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
