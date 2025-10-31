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
        'titulo',
        'descripcion_compromiso',
        'estado',
        'verificado_cumplido',
        'comentarios_compromiso',
        'puntuacion_inicial',
        'puntuacion_actual',
        'user_id',
        'responsable_id',
        'evaluacion_id',
        'tipo_compromiso',
        'usuario_rol',
        'evaluacion_has_usuario_evaluacion_id_evaluacion',
        'competencia', // Asegúrate de que esté aquí
        'nivel_actual',
        'nivel_objetivo',
        'acciones_especificas',
        'recursos_apoyo',
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


    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function evaluacion(): BelongsTo
    {
        return $this->belongsTo(Evaluacion::class, 'evaluacion_id');
    }

    public function seguimientos(): HasMany
    {
        return $this->hasMany(SeguimientoCompromiso::class, 'compromiso_id_compromiso', 'id_compromiso')
            ->orderBy('fecha_seguimiento', 'desc');
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeEnProgreso($query)
    {
        return $query->where('estado', 'en_progreso');
    }

    public function scopeCompletados($query)
    {
        return $query->where('estado', 'completado');
    }

    public function scopeVencidos($query)
    {
        return $query->where('estado', 'vencido');
    }

    // Métodos
    public function estaVencido(): bool
    {
        return $this->fecha_vencimiento < now() && $this->estado !== 'completado';
    }

    public function calcularProgreso(): int
    {
        $totalDias = $this->fecha_alta->diffInDays($this->fecha_vencimiento);
        $diasTranscurridos = $this->fecha_alta->diffInDays(now());

        return $totalDias > 0 ? min(100, intval(($diasTranscurridos / $totalDias) * 100)) : 100;
    }

    // public function seguimientos(): HasMany
    // {
    //     return $this->hasMany(SeguimientoCompromiso::class, 'compromiso_id_compromiso');
    // }
}
