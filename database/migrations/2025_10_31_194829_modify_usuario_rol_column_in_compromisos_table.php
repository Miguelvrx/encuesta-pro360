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
        Schema::table('compromisos', function (Blueprint $table) {
         $table->string('usuario_rol', 50)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('compromisos', function (Blueprint $table) {
             $table->integer('usuario_rol')->nullable()->change();
        });
    }
};
