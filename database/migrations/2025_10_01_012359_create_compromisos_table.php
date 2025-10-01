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
            $table->text('descripcion_compromiso');
            $table->boolean('verificado_cumplido')->default(false);
            $table->text('comentarios_compromiso')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->integer('usuario_rol');
            $table->unsignedBigInteger('evaluacion_has_usuario_evaluacion_id_evaluacion');
            $table->string('competencia', 255);

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
        Schema::table('compromisos', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('compromisos');
    }
};
