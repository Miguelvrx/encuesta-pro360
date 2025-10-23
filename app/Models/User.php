<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
      use HasRoles;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username', // ⭐ NUEVO CAMPO
        'password',
        'primer_apellido',
        'segundo_apellido',
        'telefono',
        'rol',
        'puesto',
        'estado',
        'genero',
        'escolaridad',
        'fecha_registro_usuario',
        'departamento_id', // <-- AÑADIR ESTO
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_registro_usuario' => 'date',
        ];
    }

    //Relaciones 
      public function departamento(): BelongsTo
    {
        // El primer argumento es la clase del modelo relacionado.
        // El segundo (opcional) es la clave foránea en la tabla 'users'.
        // El tercero (opcional) es la clave primaria en la tabla 'departamentos'.
        return $this->belongsTo(Departamento::class, 'departamento_id', 'id_departamento');
    }

    public function evaluaciones(): BelongsToMany
    {
        return $this->belongsToMany(Evaluacion::class, 'evaluacion_usuario', 'user_id', 'evaluacion_id_evaluacion')
            ->withPivot('usuario_rol', 'tipo_rol', 'fecha_de_asignacion', 'evaluado')
            ->withTimestamps();
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class, 'user_id');
    }

    public function compromisos(): HasMany
    {
        return $this->hasMany(Compromiso::class, 'user_id');
    }
}
