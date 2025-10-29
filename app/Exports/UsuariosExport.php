<?php

namespace App\Exports;

use App\Models\User;
use Illuminate\Support\Collection;
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

class UsuariosExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnWidths,
    WithStyles,
    WithEvents
{
    protected Collection $usuarios;
    private $totalRows;

    // El constructor recibe la colección de usuarios a exportar.
    public function __construct(Collection $usuarios)
    {
        $this->usuarios = $usuarios;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection(): Collection
    {
        // Guardar el número de filas para los estilos
        $this->totalRows = $this->usuarios->count() + 1; // +1 por la fila del encabezado
        return $this->usuarios;
    }

    /**
     * Define los encabezados de las columnas.
     */
    public function headings(): array
    {
        return [
            'ID',
            'Nombre',
            'Primer Apellido',
            'Segundo Apellido',
            'Email',
            'Username',  // ← NUEVA COLUMNA
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
            $usuario->id,
            $usuario->name,
            $usuario->primer_apellido,
            $usuario->segundo_apellido,
            $usuario->email,
            $usuario->username ?? 'Usa Email',  // ← NUEVA COLUMNA CON VALOR POR DEFECTO
            $usuario->telefono,
            $usuario->departamento->empresa->nombre_comercial ?? 'N/A',
            $usuario->departamento->nombre_departamento ?? 'N/A',
            $usuario->puesto,
            $usuario->rol == 2 ? 'Administrador' : 'Usuario',
            ucfirst($usuario->estado),
            ucfirst($usuario->genero ?? 'No definido'),
            $usuario->escolaridad,
            $usuario->created_at->format('d/m/Y'),
        ];
    }

    /**
     * Define el ancho de cada columna.
     */
    public function columnWidths(): array
    {
        return [
            'A' => 8,    // ID
            'B' => 20,   // Nombre
            'C' => 18,   // Primer Apellido
            'D' => 18,   // Segundo Apellido
            'E' => 30,   // Email
            'F' => 18,   // Username ← NUEVA COLUMNA
            'G' => 15,   // Teléfono
            'H' => 35,   // Empresa
            'I' => 25,   // Departamento
            'J' => 25,   // Puesto
            'K' => 15,   // Rol
            'L' => 12,   // Estado
            'M' => 12,   // Género
            'N' => 18,   // Escolaridad
            'O' => 15,   // Fecha de Registro
        ];
    }

    /**
     * Aplica estilos al worksheet.
     */
    public function styles(Worksheet $sheet)
    {
        // 1. ESTILO PARA ENCABEZADO (FILA 1)
        $sheet->getStyle('A1:O1')->applyFromArray([
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
            $dataRange = 'A2:O' . $this->totalRows;
            $sheet->getStyle($dataRange)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => 'E2E8F0'], // Borde gris claro
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ]);

            // 3. FILAS CON COLORES ALTERNADOS
            for ($row = 2; $row <= $this->totalRows; $row++) {
                $fillColor = $row % 2 == 0 ? 'FFFFFF' : 'F8FAFC'; // Blanco y gris muy claro
                $sheet->getStyle('A' . $row . ':O' . $row)
                    ->getFill()
                    ->setFillType(Fill::FILL_SOLID)
                    ->getStartColor()->setRGB($fillColor);
            }
        }

        // 4. AJUSTE DE ALTURA DE FILAS
        $sheet->getRowDimension(1)->setRowHeight(25); // Encabezado más alto

        // 5. ALINEACIÓN ESPECÍFICA PARA COLUMNAS
        // Centrar ID, Rol, Estado, Género
        if ($this->totalRows > 1) {
            $sheet->getStyle('A2:A' . $this->totalRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K2:M' . $this->totalRows)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }
    }

    /**
     * Registra eventos del worksheet.
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // 6. CONGELAR LA FILA DEL ENCABEZADO
                $event->sheet->freezePane('A2');

                // 7. AUTO FILTRO EN LOS ENCABEZADOS
                $event->sheet->setAutoFilter('A1:O1');
            },
        ];
    }
}
