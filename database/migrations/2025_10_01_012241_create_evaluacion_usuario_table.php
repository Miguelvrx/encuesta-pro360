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
        Schema::create('evaluacion_usuario', function (Blueprint $table) {
             $table->id();
            $table->unsignedBigInteger('evaluacion_id_evaluacion');
            $table->unsignedBigInteger('user_id');
            $table->integer('usuario_rol');
            $table->string('tipo_rol', 100);
            $table->date('fecha_de_asignacion');
            $table->boolean('evaluado')->default(false);

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
        Schema::table('evaluacion_usuario', function (Blueprint $table) {
            $table->dropForeign(['evaluacion_id_evaluacion']);
            $table->dropForeign(['user_id']);
        });
    }
};
