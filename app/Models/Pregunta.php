<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pregunta extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pregunta';

    protected $fillable = [
        'texto_pregunta',
        'descripcion_pregunta',
        'puntuacion_maxima',
        'orden',
        'activa',
        'competencia_id_competencia',
    ];

    protected function casts(): array
    {
        return [
            'activa' => 'boolean',
        ];
    }

    // Relaciones
    public function competencia(): BelongsTo
    {
        return $this->belongsTo(Competencia::class, 'competencia_id_competencia', 'id_competencia');
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class, 'pregunta_id_pregunta');
    }
}
