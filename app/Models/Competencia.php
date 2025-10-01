<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competencia extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_competencia';

    protected $fillable = [
        'nombre_competencia',
        'definicion_competencia',
        'nivel_comportamiento',
        'descripcion_nivel',
        'categoria_id_competencia',
    ];

    // public function categoria(): BelongsTo
    // {
    //     return $this->belongsTo(CategoriaCompetencia::class, 'categoria_id_competencia', 'id_categoria_competencia');
    // }

    public function preguntas(): HasMany
    {
        return $this->hasMany(Pregunta::class, 'competencia_id_competencia');
    }
}
