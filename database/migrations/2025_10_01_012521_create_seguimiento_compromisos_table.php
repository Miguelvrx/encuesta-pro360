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
        Schema::create('seguimiento_compromisos', function (Blueprint $table) {
            $table->id('id_seguimiento_compromiso');
            $table->string('estatus', 100);
            $table->text('comentarios')->nullable();
            $table->string('evidencia', 255)->nullable();
            $table->unsignedBigInteger('compromiso_id_compromiso');

            $table->foreign('compromiso_id_compromiso')
                ->references('id_compromiso')
                ->on('compromisos')
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
        Schema::table('seguimiento_compromisos', function (Blueprint $table) {
            $table->dropForeign(['compromiso_id_compromiso']);
        });
        Schema::dropIfExists('seguimiento_compromisos');
    }
};
