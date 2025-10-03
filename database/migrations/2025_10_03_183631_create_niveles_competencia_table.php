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
        Schema::create('niveles_competencia', function (Blueprint $table) {
             $table->id('id_nivel');
            
            // Clave foránea a la competencia principal
            $table->unsignedBigInteger('competencia_id');
            $table->foreign('competencia_id')
                  ->references('id_competencia')
                  ->on('competencias')
                  ->onDelete('cascade');

            $table->string('nombre_nivel'); // Ej: "Sobresaliente", "Competente"
            $table->text('descripcion_nivel');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('niveles_competencia');
    }
};
