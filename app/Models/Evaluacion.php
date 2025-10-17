<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';
    protected $primaryKey = 'id_evaluacion';

    protected $fillable = [
        'tipo_evaluacion',
        'fecha_inicio',
        'fecha_cierre',
        'descripcion_evaluacion',
        'uuid_encuesta',
        'configuracion_data',
        'encuestados_data',
        'calificadores_data',
        'estado',
        'paso_actual'
    ];

    protected function casts(): array
    {
        return [
            'configuracion_data' => 'array',
            'encuestados_data' => 'array',
            'calificadores_data' => 'array',
            'fecha_inicio' => 'date',
            'fecha_cierre' => 'date',
        ];
    }

    // CORRECCIÓN: Relación simplificada y corregida
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class, 
            'evaluacion_usuario', 
            'evaluacion_id_evaluacion', 
            'user_id'
        )->withPivot('usuario_rol', 'tipo_rol', 'fecha_de_asignacion', 'evaluado', 'fecha_evaluacion');
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class, 'evaluacion_id_evaluacion');
    }
}
