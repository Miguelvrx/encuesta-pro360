<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Respuesta extends Model
{
    use HasFactory;

    protected $primaryKey = 'respuesta_id';

    protected $fillable = [
        'evaluacion_has_usuario_evaluacion_id_evaluacion',
        'pregunta_id_pregunta',
        'puntuacion',
        'evaluacion_id_evaluacion',
        'user_id',
        'usuario_rol',
    ];

    // Relaciones
    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(Pregunta::class, 'pregunta_id_pregunta', 'id_pregunta');
    }

    public function evaluacion(): BelongsTo
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id_evaluacion', 'id_evaluacion');
    }

    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
