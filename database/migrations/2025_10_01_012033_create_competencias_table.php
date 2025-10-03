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
        Schema::create('competencias', function (Blueprint $table) {
            $table->id('id_competencia');
            $table->string('nombre_competencia', 255);
            $table->text('definicion_competencia');
            $table->unsignedBigInteger('categoria_id_competencia');
            $table->foreign('categoria_id_competencia')
                ->references('id_categoria_competencia')
                ->on('categoria_competencias')
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
        Schema::table('competencias', function (Blueprint $table) {
            $table->dropForeign(['categoria_id_competencia']);
        });
        Schema::dropIfExists('competencias');
    }
};
