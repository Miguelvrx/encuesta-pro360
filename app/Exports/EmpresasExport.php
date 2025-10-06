<?php

namespace App\Exports;

use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

// --- INICIO DE LA SOLUCIÓN (AÑADIR 'WithHeadings' AQUÍ) ---
class EmpresasExport implements FromCollection, WithHeadings
// --- FIN DE LA SOLUCIÓN ---
{
    protected $busqueda;
    protected $sector;
    protected $estado;

    public function __construct($busqueda, $sector, $estado)
    {
        $this->busqueda = $busqueda;
        $this->sector = $sector;
        $this->estado = $estado;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $query = Empresa::query();

        if ($this->busqueda) {
            $query->where(function ($q) {
                $q->where('nombre_comercial', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('razon_social', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('rfc', 'like', '%' . $this->busqueda . '%');
            });
        }

        if ($this->sector) {
            $query->where('sector', $this->sector);
        }

        if ($this->estado) {
            $query->where('estado_inicial', $this->estado);
        }

        // Seleccionamos los campos en el orden que queremos que aparezcan en el Excel.
        return $query->get([
            'nombre_comercial',
            'rfc',
            'sector',
            'pais',
            'estado',
            'municipio',
            'ciudad',
            'fecha_registro',
            'estado_inicial',
        ]);
    }

    // --- INICIO DE LA SOLUCIÓN (AÑADIR ESTE MÉTODO COMPLETO) ---
    /**
     * Define los encabezados de las columnas en el archivo Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Nombre Comercial',
            'RFC',
            'Sector',
            'País',
            'Estado',
            'Municipio',
            'Ciudad',
            'Fecha de Registro',
            'Estado Actual',
        ];
    }
    // --- FIN DE LA SOLUCIÓN ---
}
