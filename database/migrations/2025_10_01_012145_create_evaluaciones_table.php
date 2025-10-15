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
        Schema::create('evaluaciones', function (Blueprint $table) {
            $table->id('id_evaluacion');
            $table->string('tipo_evaluacion', 100);
            $table->date('fecha_inicio');
            $table->date('fecha_cierre');
            $table->text('descripcion_evaluacion');
            $table->string('uuid_encuesta', 36)->unique();

             // Campos para control de flujo y guardado automático
            $table->json('configuracion_data')->nullable(); // Competencias y preguntas seleccionadas
            $table->json('encuestados_data')->nullable();   // Personas evaluadas
            $table->json('calificadores_data')->nullable(); // Calificadores asignados
            $table->enum('estado', ['borrador', 'revision', 'completada'])->default('borrador');
            $table->integer('paso_actual')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluaciones');
    }
};
