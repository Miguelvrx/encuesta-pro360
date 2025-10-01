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
        Schema::create('preguntas', function (Blueprint $table) {
               $table->id('id_pregunta');
            $table->text('texto_pregunta');
            $table->text('descripcion_pregunta');
            $table->integer('puntuacion_maxima');
            $table->integer('orden');
            $table->boolean('activa')->default(true);
            $table->unsignedBigInteger('competencia_id_competencia');
            $table->foreign('competencia_id_competencia')
                ->references('id_competencia')
                ->on('competencias')
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
          Schema::table('preguntas', function (Blueprint $table) {
            $table->dropForeign(['competencia_id_competencia']);
        });
        Schema::dropIfExists('preguntas');
    }
};
