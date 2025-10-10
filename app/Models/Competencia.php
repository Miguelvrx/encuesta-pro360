<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competencia extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_competencia';

    // Quitamos los campos de nivel que ya no existen aquí
    protected $fillable = [
        'nombre_competencia',
        'definicion_competencia',
        'categoria_id_competencia',
    ];

    // Nueva relación: Una competencia tiene muchos niveles
    public function niveles(): HasMany
    {
        return $this->hasMany(Nivel::class, 'competencia_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'categoria_id_competencia');
    }


    // public function categoria(): BelongsTo
    // {
    //     return $this->belongsTo(Competencia::class, 'categoria_id_competencia');
    // }

    // La relación con Preguntas se queda igual, ¡está perfecta!
    public function preguntas(): HasMany
    {
        return $this->hasMany(Pregunta::class, 'competencia_id_competencia');
    }
}
