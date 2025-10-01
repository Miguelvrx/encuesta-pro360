<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Compromiso extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_compromiso';

    protected $fillable = [
        'fecha_alta',
        'fecha_vencimiento',
        'descripcion_compromiso',
        'verificado_cumplido',
        'comentarios_compromiso',
        'user_id',
        'usuario_rol',
        'evaluacion_has_usuario_evaluacion_id_evaluacion',
        'competencia',
    ];

    protected function casts(): array
    {
        return [
            'fecha_alta' => 'date',
            'fecha_vencimiento' => 'date',
            'verificado_cumplido' => 'boolean',
        ];
    }

    // Relaciones
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // public function seguimientos(): HasMany
    // {
    //     return $this->hasMany(SeguimientoCompromiso::class, 'compromiso_id_compromiso');
    // }
}
