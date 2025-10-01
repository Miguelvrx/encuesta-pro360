<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Departamento extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_departamento';

    protected $fillable = [
        'nombre_departamento',
        'descripcion',
        'estado',
        'puesto',
        'fecha_registro_departamento',
        'empresa_id_empresa',
    ];

    protected function casts(): array
    {
        return [
            'fecha_registro_departamento' => 'date',
        ];
    }

    // Relaciones
    public function empresa(): BelongsTo
    {
        return $this->belongsTo(Empresa::class, 'empresa_id_empresa', 'id_empresa');
    }
}
