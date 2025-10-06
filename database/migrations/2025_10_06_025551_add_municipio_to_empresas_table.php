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
        Schema::table('empresas', function (Blueprint $table) {
               // Añadimos la nueva columna 'municipio' después de 'ciudad'
            $table->string('municipio', 100)->after('ciudad')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empresas', function (Blueprint $table) {
             // Lógica para revertir el cambio (eliminar la columna)
            $table->dropColumn('municipio');
        });
    }
};
