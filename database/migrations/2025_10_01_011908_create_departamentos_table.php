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
        Schema::create('departamentos', function (Blueprint $table) {
            $table->id('id_departamento');
            $table->string('nombre_departamento', 255);
            $table->text('descripcion');
            $table->enum('estado', ['activo', 'inactivo']);
            $table->string('puesto', 100);
            $table->date('fecha_registro_departamento');
            $table->unsignedBigInteger('empresa_id_empresa');
            $table->foreign('empresa_id_empresa')
                ->references('id_empresa')
                ->on('empresas')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departamentos');
    }
};
