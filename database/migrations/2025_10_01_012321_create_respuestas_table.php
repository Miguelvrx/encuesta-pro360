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
        Schema::create('respuestas', function (Blueprint $table) {
            $table->id('respuesta_id');
            $table->unsignedBigInteger('evaluacion_has_usuario_evaluacion_id_evaluacion');
            $table->unsignedBigInteger('pregunta_id_pregunta');
            $table->integer('puntuacion');
            $table->unsignedBigInteger('evaluacion_id_evaluacion');
            $table->unsignedBigInteger('user_id');
            $table->integer('usuario_rol');

            $table->foreign('pregunta_id_pregunta')
                ->references('id_pregunta')
                ->on('preguntas')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('evaluacion_id_evaluacion')
                ->references('id_evaluacion')
                ->on('evaluaciones')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::table('respuestas', function (Blueprint $table) {
            $table->dropForeign(['pregunta_id_pregunta']);
            $table->dropForeign(['evaluacion_id_evaluacion']);
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('respuestas');
    }
};
