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
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


// --- INICIO DE LA SOLUCIÓN (AÑADIR 'WithHeadings' AQUÍ) ---
class EmpresasExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    WithColumnWidths, // Para definir el ancho de las columnas
    WithStyles,       // Para aplicar estilos (colores, bordes, etc.)
    WithEvents        // Para registrar eventos (como congelar el encabezado)
{
    protected $busqueda;
    protected $sector;
    protected $estado;
    private $totalRows; // Propiedad para guardar el número de filas

    public function __construct($busqueda, $sector, $estado)
    {
        $this->busqueda = $busqueda;
        $this->sector = $sector;
        $this->estado = $estado;
    }

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

        $collection = $query->orderBy('id_empresa')->get();
        $this->totalRows = $collection->count() + 1; // +1 por la fila del encabezado
        return $collection;
    }

    public function headings(): array
    {
        // Encabezados más claros y concisos
        return [
            'ID',
            'Logo',
            'Nombre Comercial',
            'Razón Social',
            'RFC',
            'Estado',
            'Sector',
            'Nº Empleados',
            'Año en Mercado',
            'Tipo de Organización',
            'Dirección',
            'Fecha Registro',
            'Contacto',
            'Puesto Contacto',
            'Teléfono',
            'Email',
        ];
    }

    public function map($empresa): array
    {
        // Mapeamos los datos en el mismo orden que los encabezados
        return [
            $empresa->id_empresa,
            $empresa->logo ? 'Sí' : 'No',
            $empresa->nombre_comercial,
            $empresa->razon_social,
            $empresa->rfc,
            $empresa->estado_inicial,
            $empresa->sector,
            $empresa->numero_empleados,
            $empresa->ano_mercado,
            $empresa->tipo_organizacion,
            // Concatenamos la dirección completa
            trim("{$empresa->direccion}, {$empresa->municipio}, {$empresa->estado}, C.P. {$empresa->codigo_postal}", ", "),
            $empresa->fecha_registro->format('d/m/Y'),
            $empresa->contacto_nombre,
            $empresa->contacto_puesto,
            $empresa->contacto_telefono,
            $empresa->contacto_correo,
        ];
    }

    public function columnFormats(): array
    {
        // Formato de texto para columnas que pueden ser malinterpretadas como números
        return [
            'E' => NumberFormat::FORMAT_TEXT, // RFC
            'I' => NumberFormat::FORMAT_TEXT, // Año Mercado
            'O' => NumberFormat::FORMAT_TEXT, // Teléfono
        ];
    }

    public function columnWidths(): array
    {
        // Anchos de columna para una mejor visualización
        return [
            'A' => 8,    // ID
            'B' => 8,    // Logo
            'C' => 35,   // Nombre Comercial
            'D' => 35,   // Razón Social
            'E' => 18,   // RFC
            'F' => 12,   // Estado
            'G' => 20,   // Sector
            'H' => 15,   // Nº Empleados
            'I' => 15,   // Año en Mercado
            'J' => 20,   // Tipo de Organización
            'K' => 45,   // Dirección
            'L' => 15,   // Fecha Registro
            'M' => 25,   // Contacto
            'N' => 25,   // Puesto Contacto
            'O' => 18,   // Teléfono
            'P' => 30,   // Email
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. ESTILO PARA ENCABEZADO (FILA 1)
        $sheet->getStyle('A1:P1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '003366'], // Azul oscuro corporativo
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 2. ESTILO PARA TODAS LAS CELDAS DE DATOS
        if ($this->totalRows > 1) {
            $dataRange = 'A2:P' . $this->totalRows;
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E2E8F0'], // Borde gris claro
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true, // Permite que el texto salte de línea si no cabe
                ],
            ]);

            // 3. FILAS CON COLORES ALTERNADOS (mejor legibilidad)
            for ($row = 2; $row <= $this->totalRows; $row++) {
                $fillColor = $row % 2 == 0 ? 'FFFFFF' : 'F8FAFC'; // Blanco y gris muy claro
                $sheet->getStyle('A' . $row . ':P' . $row)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB($fillColor);
            }
        }

        // 4. AJUSTE DE ALTURA DE FILAS
        $sheet->getRowDimension(1)->setRowHeight(25); // Encabezado más alto
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // 5. CONGELAR LA FILA DEL ENCABEZADO
                $event->sheet->freezePane('A2');

                // 6. AUTO FILTRO EN LOS ENCABEZADOS
                $event->sheet->setAutoFilter('A1:P1');
            },
        ];
    }
}
