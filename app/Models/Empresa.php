<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Empresa extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_empresa';

    protected $fillable = [
        //Campos Obligatorios En formulario
        'nombre_comercial',
        'razon_social',
        'sector',
        'estado_inicial',
        'numero_empleados',
        'fecha_registro',
        'ano_mercado',
        'tipo_organizacion',
        //Opcional 
        'image',

        //Campos Obligatorios En formulario
        'rfc',
        'pais',
        'estado',
        'ciudad',
        'direccion',
        'municipio', // <-- AÑADIR ESTA LÍNEA
        'codigo_postal',
        //Opcional 
        'contacto_nombre',
        'contacto_puesto',
        'contacto_telefono',
        'contacto_correo',
    ];

    protected function casts(): array
    {
        return [
            'fecha_registro' => 'date',
        ];
    }

    // Relaciones
    public function departamentos(): HasMany
    {
        return $this->hasMany(Departamento::class, 'empresa_id_empresa');
    }
}
