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
            $table->date('fecha_seguimiento')->useCurrent();
            $table->string('estatus', 100);
            $table->text('comentarios')->nullable();
            $table->string('evidencia', 255)->nullable();
            $table->text('avance');
            $table->decimal('puntuacion_actual', 3, 2)->nullable();
            $table->text('evidencias')->nullable();
            $table->text('obstaculos')->nullable();
            $table->text('siguientes_pasos')->nullable();
            $table->unsignedBigInteger('registrado_por');
            $table->unsignedBigInteger('compromiso_id_compromiso');

            // Foreign keys
            $table->foreign('compromiso_id_compromiso')
                ->references('id_compromiso')
                ->on('compromisos')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('registrado_por')
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
        Schema::table('seguimiento_compromisos', function (Blueprint $table) {
            $table->dropForeign(['compromiso_id_compromiso']);
            $table->dropForeign(['registrado_por']);
        });
        Schema::dropIfExists('seguimiento_compromisos');
    }
};
