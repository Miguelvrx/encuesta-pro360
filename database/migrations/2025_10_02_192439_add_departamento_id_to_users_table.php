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
        Schema::table('users', function (Blueprint $table) {
            // Añadimos la columna y la clave foránea en un solo paso.
            // Laravel es lo suficientemente inteligente para saber que debe añadir la columna primero.
            $table->foreignId('departamento_id')
                  ->nullable()
                  ->after('fecha_registro_usuario') // Opcional: para colocar la columna en un lugar específico
                  ->constrained('departamentos', 'id_departamento')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
              // El método down debe revertir exactamente lo que hizo el método up
            $table->dropForeign(['departamento_id']);
            $table->dropColumn('departamento_id');
        });
    }
};
