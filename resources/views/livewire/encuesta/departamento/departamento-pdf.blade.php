<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Departamentos</title>
    <style>
        /* ==========================
           ESTILOS GENERALES
        =========================== */
        @page {
            margin: 20px 25px;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #1e293b;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        h1,
        h3,
        p {
            margin: 0;
            padding: 0;
        }

        /* ==========================
           ENCABEZADO
        =========================== */
        .header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        .header td {
            vertical-align: top;
            padding: 0;
        }

        .header-logo {
            width: 150px;
        }

        .header-logo img {
            max-width: 120px;
            height: auto;
        }

        .header-info {
            text-align: right;
            padding-top: 10px;
            /* Pequeño ajuste para alinear con el logo */
        }

        .header h1 {
            font-size: 16px;
            color: #1e40af;
            /* Azul oscuro */
            font-weight: bold;
            border-bottom: 2px solid #3b82f6;
            /* Línea azul */
            padding-bottom: 5px;
            margin-bottom: 3px;
        }

        .header-meta {
            font-size: 9px;
            color: #64748b;
        }

        /* ==========================
           FILTROS
        =========================== */
        .filters-bar {
            background: #eff6ff;
            /* Azul muy claro */
            border-left: 4px solid #3b82f6;
            /* Azul */
            padding: 8px 12px;
            margin-bottom: 15px;
            font-size: 9px;
            color: #1e40af;
        }

        .filters-bar strong {
            font-weight: bold;
            color: #1e3a8a;
        }

        /* ==========================
           TABLA DE DATOS
        =========================== */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-bottom: 20px;
        }

        .data-table thead th {
            background-color: #3b82f6;
            /* Azul principal */
            color: #ffffff;
            padding: 8px 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #3b82f6;
            text-transform: uppercase;
        }

        .data-table tbody td {
            padding: 8px 10px;
            border: 1px solid #e2e8f0;
            /* Gris muy claro */
            vertical-align: top;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
            /* Alternar filas */
        }

        .data-table tbody tr:hover {
            background-color: #eff6ff;
        }

        /* Estilos específicos de columna */
        .col-id {
            width: 5%;
            text-align: center;
        }

        .col-departamento {
            width: 15%;
            font-weight: bold;
        }

        .col-empresa {
            width: 15%;
        }

        .col-puesto {
            width: 15%;
        }

        .col-fecha {
            width: 10%;
            text-align: center;
        }

        .col-estado {
            width: 10%;
            text-align: center;
        }

        .col-descripcion {
            width: 30%;
            max-width: 30%;
            word-wrap: break-word;
            line-height: 1.2;
            /* Reducir el interlineado para ahorrar espacio vertical */
            font-size: 9px;
            /* Asegurar que el texto de la descripción sea un poco más pequeño */
        }

        /* Badge de estado */
        .badge {
            font-size: 8px;
            font-weight: bold;
            border-radius: 4px;
            padding: 3px 6px;
            text-transform: uppercase;
            display: inline-block;
        }

        .badge-activo {
            background-color: #d1fae5;
            /* Verde claro */
            color: #065f46;
            /* Verde oscuro */
        }

        .badge-inactivo {
            background-color: #fee2e2;
            /* Rojo claro */
            color: #991b1b;
            /* Rojo oscuro */
        }

        /* Imagen de la empresa */
        .empresa-img {
            max-width: 40px;
            max-height: 20px;
            display: block;
            margin: 0 auto;
        }

        /* ==========================
           ESTADO VACÍO
        =========================== */
        .empty-state {
            text-align: center;
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            padding: 30px 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .empty-state-text {
            color: #64748b;
            font-size: 10px;
        }

        /* ==========================
           PIE DE PÁGINA
        =========================== */
        .footer {
            width: 100%;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            /* Volver a centrar el texto del footer */
            font-size: 8px;
            color: #64748b;
            padding: 8px 0;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .page-number:before {
            content: "Página " counter(page) " de " counter(pages);
        }

        .footer-brand {
            font-weight: bold;
            color: #1e40af;
        }
    </style>
</head>

<body>

    {{-- Header --}}
    <table class="header">
        <tr>
            <td class="header-logo">
                {{-- Asumiendo que el logo está en public/images/cesrhv.png --}}
                <img src="{{ public_path('images/cesrhv.png') }}" alt="Logo">
            </td>
            <td class="header-info">
                <h1>Listado de Departamentos Registrados</h1>
                <p class="header-meta">Generado el {{ now()->format('d/m/Y') }} a las {{ now()->format('H:i:s') }}</p>
            </td>
        </tr>
    </table>

    {{-- Filtros --}}
    <div class="filters-bar">
        <strong>Filtros aplicados:</strong>
        <span>
            {{ $busqueda || $filtroEmpresa || $filtroEstado
                ? ($busqueda ? "Búsqueda: \"$busqueda\"" : '') .
                  ($filtroEmpresa ? " • Empresa: $filtroEmpresa" : '') .
                  ($filtroEstado ? " • Estado: " . ucfirst($filtroEstado) : '')
                : 'Todos los registros' }}
        </span>
    </div>

    {{-- Listado en Tabla --}}
    @if ($departamentos->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th class="col-id">ID</th>
                <th class="col-departamento">Departamento</th>
                <th class="col-descripcion">Descripción</th>
                <th class="col-empresa">Empresa</th>
                <th class="col-puesto">Puesto Principal</th>
                <th class="col-fecha">Reg.</th>
                <th class="col-estado">Estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($departamentos as $departamento)
            <tr>
                <td class="col-id">#{{ $departamento->id_departamento }}</td>
                <td class="col-departamento">{{ $departamento->nombre_departamento }}</td>
                <td class="col-descripcion">{{ Str::limit($departamento->descripcion, 100, '...') }}</td>
                <td class="col-empresa">
                    @if($departamento->empresa)
                    {{ $departamento->empresa->nombre_comercial }}
                    @else
                    N/A
                    @endif
                </td>
                <td class="col-puesto">{{ $departamento->puesto ?? 'N/A' }}</td>
                <td class="col-fecha">
                    {{ $departamento->fecha_registro_departamento
                        ? $departamento->fecha_registro_departamento->format('d/m/Y')
                        : 'N/A' }}
                </td>
                <td class="col-estado">
                    <span class="badge badge-{{ strtolower($departamento->estado) }}">
                        {{ ucfirst($departamento->estado) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="empty-state">
        <p class="empty-state-text">📋 No se encontraron departamentos con los filtros aplicados.</p>
    </div>
    @endif

    {{-- Footer --}}
    {{-- Nota: DomPDF no soporta 'position: fixed' perfectamente, pero lo incluimos como buena práctica. --}}
    <div class="footer">
        <span class="page-number"></span> • <span class="footer-brand">CESRH Consultoría y Coaching</span> • {{ now()->format('d/m/Y') }} • Confidencial
    </div>

</body>

</html>