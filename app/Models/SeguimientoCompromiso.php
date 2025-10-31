<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeguimientoCompromiso extends Model
{
     use HasFactory;

    protected $primaryKey = 'id_seguimiento_compromiso';

    protected $fillable = [
        'fecha_seguimiento',
        'estatus',
        'comentarios',
        'evidencia',
        'avance',
        'puntuacion_actual',
        'evidencias',
        'obstaculos',
        'siguientes_pasos',
        'registrado_por',
        'compromiso_id_compromiso'
    ];

    protected $casts = [
        'fecha_seguimiento' => 'date',
        'puntuacion_actual' => 'decimal:2',
    ];

    public function compromiso(): BelongsTo
    {
        return $this->belongsTo(Compromiso::class, 'compromiso_id_compromiso', 'id_compromiso');
    }

    public function registradoPor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registrado_por');
    }
}
