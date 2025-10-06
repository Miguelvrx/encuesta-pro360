<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nivel extends Model
{
     use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'niveles_competencia'; // ¡SOLUCIÓN! Le decimos el nombre correcto de la tabla.

    /**
     * La clave primaria para el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id_nivel'; // Indicamos la clave primaria personalizada.

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'competencia_id',
        'nombre_nivel',
        'descripcion_nivel',
    ];

    /**
     * Define la relación: un nivel pertenece a una competencia.
     */
    public function competencia(): BelongsTo
    {
        return $this->belongsTo(Competencia::class, 'competencia_id');
    }

}
