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
        Schema::create('compromisos', function (Blueprint $table) {
            $table->id('id_compromiso');
            $table->date('fecha_alta');
            $table->date('fecha_vencimiento');
            $table->string('titulo', 255);
            $table->text('descripcion_compromiso');
            $table->enum('estado', ['pendiente', 'en_progreso', 'completado', 'vencido'])->default('pendiente');
            $table->boolean('verificado_cumplido')->default(false);
            $table->text('comentarios_compromiso')->nullable();
            $table->decimal('puntuacion_inicial', 3, 2)->nullable();
            $table->decimal('puntuacion_actual', 3, 2)->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('responsable_id');
            $table->unsignedBigInteger('evaluacion_id');
            $table->string('tipo_compromiso', 50)->default('mejora');
            $table->integer('usuario_rol');
            $table->unsignedBigInteger('evaluacion_has_usuario_evaluacion_id_evaluacion');
            $table->string('competencia', 255);
            $table->string('nivel_actual', 100);
            $table->string('nivel_objetivo', 100);
            $table->text('acciones_especificas');
            $table->text('recursos_apoyo')->nullable();

            // Foreign keys
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('responsable_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('evaluacion_id')
                ->references('id_evaluacion')
                ->on('evaluaciones')
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
        Schema::table('compromisos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['responsable_id']);
            $table->dropForeign(['evaluacion_id']);
        });
        Schema::dropIfExists('compromisos');
    }
};
