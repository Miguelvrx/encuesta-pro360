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
        'configuracion_data', // JSON con configuración
        'encuestados_data',   // JSON con encuestados
        'calificadores_data', // JSON con calificadores
        'estado', // 'borrador', 'revision', 'completada'
        'paso_actual' // 1, 2, 3, 4, 5, 6
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

    // Relaciones
    public function usuarios(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'evaluacion_usuario', 'evaluacion_id_evaluacion', 'user_id')
            ->withPivot('usuario_rol', 'tipo_rol', 'fecha_de_asignacion', 'evaluado')
            ->withTimestamps();
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class, 'evaluacion_id_evaluacion');
    }
}
