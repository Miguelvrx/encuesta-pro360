<?php

namespace App\Exports;

use App\Models\Empresa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// --- INICIO DE LA SOLUCIÓN (AÑADIR 'WithHeadings' AQUÍ) ---
class EmpresasExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting
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

        return $query->orderBy('id_empresa')->get();
    }

    /**
     * Define los encabezados en el orden CORRECTO
     */
    public function headings(): array
    {
        return [
            'ID',
            'Logo',
            'Nombre Comercial',
            'RFC',
            'Sector',
            'País',
            'Ubicación',
            'Fecha de Registro',
            'Estado',
            'Razón Social',
            'Número Empleados',
            'Año Mercado',
            'Tipo Organización',
            'Contacto Nombre',
            'Contacto Puesto',
            'Contacto Teléfono',
            'Contacto Correo',
        ];
    }

    /**
     * Mapea los datos en el orden CORRECTO
     */
    public function map($empresa): array
    {
        return [
            // COLUMNA A - ID
            $empresa->id_empresa,

            // COLUMNA B - Logo (indicador)
            $empresa->logo ? 'Sí' : 'No',

            // COLUMNA C - Nombre Comercial
            $empresa->nombre_comercial,

            // COLUMNA D - RFC (formato texto para evitar conversión científica)
            $empresa->rfc,

            // COLUMNA E - Sector
            $empresa->sector,

            // COLUMNA F - País
            $empresa->pais,

            // COLUMNA G - Ubicación Completa
            ($empresa->municipio ?? $empresa->ciudad) . ', ' . $empresa->estado,

            // COLUMNA H - Fecha Registro (formato legible)
            $empresa->fecha_registro->format('d/m/Y'),

            // COLUMNA I - Estado
            $empresa->estado_inicial,

            // COLUMNA J - Razón Social
            $empresa->razon_social,

            // COLUMNA K - Número Empleados
            $empresa->numero_empleados,

            // COLUMNA L - Año Mercado
            $empresa->ano_mercado,

            // COLUMNA M - Tipo Organización
            $empresa->tipo_organizacion,

            // COLUMNA N - Contacto Nombre
            $empresa->contacto_nombre,

            // COLUMNA O - Contacto Puesto
            $empresa->contacto_puesto,

            // COLUMNA P - Contacto Teléfono
            $empresa->contacto_telefono,

            // COLUMNA Q - Contacto Correo
            $empresa->contacto_correo,
        ];
    }

    /**
     * Formato de columnas para evitar conversión automática
     */
    public function columnFormats(): array
    {
        return [
            // Columna D (RFC) como texto para preservar formato
            'D' => NumberFormat::FORMAT_TEXT,
            // Columna L (Año Mercado) como texto
            'L' => NumberFormat::FORMAT_TEXT,
        ];
    }

    /**
     * Aplica estilos profesionales
     */
    public function styles(Worksheet $sheet)
    {
        $totalRows = $this->collection()->count() + 1;

        // 1. ESTILO PARA ENCABEZADO (fila 1)
        $sheet->getStyle('A1:Q1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 11,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '003366'],
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 2. ESTILO PARA DATOS (filas 2 en adelante)
        if ($totalRows > 1) {
            $sheet->getStyle('A2:Q' . $totalRows)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'DDDDDD'],
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ]);

            // Filas alternadas para mejor legibilidad
            for ($row = 2; $row <= $totalRows; $row++) {
                $fillColor = $row % 2 == 0 ? 'FFFFFF' : 'F8FAFC';
                $sheet->getStyle('A' . $row . ':Q' . $row)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->setStartColor(['rgb' => $fillColor]);
            }
        }

        // 3. AJUSTE DE ANCHO DE COLUMNAS
        $columns = [
            'A' => 8,   // ID
            'B' => 8,   // Logo
            'C' => 30,  // Nombre Comercial
            'D' => 18,  // RFC (más ancho para formato completo)
            'E' => 15,  // Sector
            'F' => 12,  // País
            'G' => 25,  // Ubicación
            'H' => 15,  // Fecha Registro
            'I' => 12,  // Estado
            'J' => 30,  // Razón Social
            'K' => 15,  // Número Empleados
            'L' => 12,  // Año Mercado
            'M' => 18,  // Tipo Organización
            'N' => 20,  // Contacto Nombre
            'O' => 18,  // Contacto Puesto
            'P' => 16,  // Contacto Teléfono
            'Q' => 25,  // Contacto Correo
        ];

        foreach ($columns as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // 4. ALINEACIÓN DE COLUMNAS
        $centeredColumns = ['A', 'B', 'I', 'H', 'K', 'L']; // ID, Logo, Estado, Fecha, Empleados, Año
        foreach ($centeredColumns as $column) {
            $sheet->getStyle($column . '1:' . $column . $totalRows)
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // 5. AJUSTE DE ALTURA DE FILAS
        $sheet->getRowDimension(1)->setRowHeight(25); // Encabezado más alto
        for ($row = 2; $row <= $totalRows; $row++) {
            $sheet->getRowDimension($row)->setRowHeight(20);
        }

        // 6. CONGELAR PANEL (fijar encabezado)
        $sheet->freezePane('A2');

        return [];
    }
}
