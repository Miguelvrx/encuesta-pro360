<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categoria extends Model
{
     use HasFactory;

    /**
     * La tabla asociada con el modelo.
     *
     * @var string
     */
    protected $table = 'categoria_competencias'; // Le decimos explícitamente el nombre de la tabla

    /**
     * La clave primaria para el modelo.
     *
     * @var string
     */
    protected $primaryKey = 'id_categoria_competencia'; // Le indicamos nuestra clave primaria personalizada

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'categoria',
    ];

    /**
     * Define la relación: una categoría tiene muchas competencias.
     */
    public function competencias(): HasMany
    {
        // El primer argumento es el modelo relacionado.
        // El segundo es la clave foránea en la tabla 'competencias'.
        return $this->hasMany(Competencia::class, 'categoria_id_competencia');
    }

}
