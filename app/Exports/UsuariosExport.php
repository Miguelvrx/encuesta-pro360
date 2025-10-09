<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsuariosExport implements FromCollection
{
    protected Collection $usuarios;

    // El constructor ahora recibe la colección de usuarios a exportar.
    public function __construct(Collection $usuarios)
    {
        $this->usuarios = $usuarios;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection(): Collection
    {
        return $this->usuarios;
    }

    /**
     * Define los encabezados de las columnas.
     */
    public function headings(): array
    {
        return [
            'Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Email',
            'Teléfono',
            'Empresa',
            'Departamento',
            'Puesto',
            'Rol',
            'Estado',
            'Género',
            'Escolaridad',
            'Fecha de Registro',
        ];
    }

    /**
     * Mapea los datos de cada usuario a las columnas del Excel.
     * @param mixed $usuario
     * @return array
     */
    public function map($usuario): array
    {
        return [
            $usuario->name,
            $usuario->primer_apellido,
            $usuario->segundo_apellido,
            $usuario->email,
            $usuario->telefono,
            $usuario->departamento->empresa->nombre_comercial ?? 'N/A',
            $usuario->departamento->nombre_departamento ?? 'N/A',
            $usuario->puesto,
            $usuario->rol == 2 ? 'Administrador' : 'Usuario', // Asumiendo 2=Admin, 1=Usuario
            ucfirst($usuario->estado),
            ucfirst($usuario->genero ?? 'No definido'),
            $usuario->escolaridad,
            $usuario->created_at->format('d/m/Y'),
        ];
    }
}
