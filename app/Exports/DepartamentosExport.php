<?php

namespace App\Exports;

use App\Models\Departamento;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Maatwebsite\Excel\Concerns\WithEvents;

class DepartamentosExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnWidths,
    WithStyles,
    WithEvents
{
    protected $busqueda;
    protected $filtroEmpresa;
    protected $filtroEstado;
    protected $ordenarPor;
    protected $direccionOrden;
    private $totalRows;

    public function __construct($busqueda, $filtroEmpresa, $filtroEstado, $ordenarPor, $direccionOrden)
    {
        $this->busqueda = $busqueda;
        $this->filtroEmpresa = $filtroEmpresa;
        $this->filtroEstado = $filtroEstado;
        $this->ordenarPor = $ordenarPor;
        $this->direccionOrden = $direccionOrden;
    }

    public function collection()
    {
        // 1. Iniciar la consulta con la relación 'empresa'
        $query = Departamento::with('empresa');

        // 2. Aplicar filtros (tomados de MostrarDepartamento::exportarPdf)
        if ($this->busqueda) {
            $query->where(function ($q) {
                $q->where('nombre_departamento', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('puesto', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->busqueda . '%');
            });
        }

        if ($this->filtroEmpresa) {
            $query->where('empresa_id_empresa', $this->filtroEmpresa);
        }

        if ($this->filtroEstado) {
            $query->where('estado', $this->filtroEstado);
        }

        // 3. Aplicar ordenación
        $collection = $query->orderBy($this->ordenarPor, $this->direccionOrden)->get();

        // Guardar el número de filas para los estilos
        $this->totalRows = $collection->count() + 1; // +1 por la fila del encabezado
        return $collection;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Departamento',
            'Descripción',
            'Puesto Principal',
            'Empresa (ID)',
            'Empresa (Nombre)',
            'Estado',
            'Fecha Registro',
        ];
    }

    public function map($departamento): array
    {
        // Mapeamos los datos en el mismo orden que los encabezados
        return [
            $departamento->id_departamento,
            $departamento->nombre_departamento,
            $departamento->descripcion,
            $departamento->puesto,
            $departamento->empresa_id_empresa,
            $departamento->empresa->nombre_comercial ?? 'N/A',
            $departamento->estado,
            $departamento->fecha_registro_departamento ? $departamento->fecha_registro_departamento->format('d/m/Y') : 'N/A',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 8,    // ID
            'B' => 25,   // Departamento
            'C' => 50,   // Descripción
            'D' => 25,   // Puesto Principal
            'E' => 10,   // Empresa (ID)
            'F' => 35,   // Empresa (Nombre)
            'G' => 12,   // Estado
            'H' => 15,   // Fecha Registro
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // 1. ESTILO PARA ENCABEZADO (FILA 1)
        $sheet->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'],
                'size' => 12,
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '003366'], // Azul oscuro corporativo (tomado de EmpresasExport)
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ]);

        // 2. ESTILO PARA TODAS LAS CELDAS DE DATOS
        if ($this->totalRows > 1) {
            $dataRange = 'A2:H' . $this->totalRows;
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E2E8F0'], // Borde gris claro
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP, // Ajustado a TOP para descripciones largas
                    'wrapText' => true,
                ],
            ]);

            // 3. FILAS CON COLORES ALTERNADOS
            for ($row = 2; $row <= $this->totalRows; $row++) {
                $fillColor = $row % 2 == 0 ? 'FFFFFF' : 'F8FAFC'; // Blanco y gris muy claro
                $sheet->getStyle('A' . $row . ':H' . $row)
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
                $event->sheet->setAutoFilter('A1:H1');
            },
        ];
    }
}
