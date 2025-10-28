<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Departamentos</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #1e293b;
            margin: 0;
            padding: 20px;
            background: #ffffff;
        }

        /* Header usando tabla */
        .header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 10px;
        }

        .header td {
            vertical-align: middle;
            padding: 10px 0;
        }

        .header-logo {
            width: 160px;
        }

        .header-logo img {
            max-width: 160px;
            height: auto;
        }

        .header-info {
            text-align: right;
        }

        .header h1 {
            font-size: 18px;
            margin: 0 0 5px 0;
            color: #4f46e5;
            font-weight: 700;
        }

        .header-meta {
            font-size: 9px;
            color: #64748b;
            margin: 0;
        }

        /* Filtros aplicados */
        .filters-bar {
            background: #f1f5f9;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #4f46e5;
        }

        .filters-bar strong {
            color: #334155;
            font-size: 9px;
        }

        .filters-bar span {
            color: #475569;
            font-size: 9px;
        }

        /* Section title */
        .section-title {
            font-size: 13px;
            color: #0f172a;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #e2e8f0;
            font-weight: 700;
            text-transform: uppercase;
        }

        /* Card de departamento usando tabla */
        .departamento-card {
            width: 100%;
            border-collapse: collapse;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }

        /* Card header */
        .card-header {
            background: #4f46e5;
            padding: 0;
        }

        .card-header td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .card-avatar-cell {
            width: 55px;
            text-align: center;
        }

        .card-avatar {
            width: 45px;
            height: 45px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.2);
            border: 2px solid rgba(255, 255, 255, 0.3);
            text-align: center;
            line-height: 45px;
            font-size: 16px;
            font-weight: 700;
            color: #ffffff;
            display: inline-block;
        }

        .card-title {
            font-size: 13px;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 3px 0;
        }

        .card-id {
            font-size: 9px;
            color: rgba(255, 255, 255, 0.8);
            margin: 0;
        }

        .card-status-cell {
            width: 80px;
            text-align: right;
        }

        .card-status {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 8px;
            font-weight: 600;
            text-transform: uppercase;
            display: inline-block;
        }

        .badge-activo {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-inactivo {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Card body */
        .card-body {
            padding: 15px;
        }

        .description-box {
            background: #f8fafc;
            padding: 10px;
            border-radius: 6px;
            border-left: 3px solid #4f46e5;
            margin-bottom: 12px;
        }

        .info-label {
            font-size: 8px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 10px;
            color: #1e293b;
            font-weight: 500;
            line-height: 1.5;
        }

        /* Tabla de info usando tabla real */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
        }

        .info-table td {
            padding: 8px 10px 8px 0;
            vertical-align: top;
            width: 50%;
        }

        /* Card footer */
        .card-footer {
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        .card-footer td {
            padding: 12px 15px;
            vertical-align: middle;
        }

        .empresa-logo-cell {
            width: 50px;
            text-align: center;
        }

        .empresa-logo {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
        }

        .empresa-placeholder {
            width: 40px;
            height: 40px;
            border-radius: 6px;
            background: #64748b;
            color: white;
            text-align: center;
            line-height: 40px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .empresa-name {
            font-size: 10px;
            color: #0f172a;
            font-weight: 600;
            margin: 0 0 2px 0;
        }

        .empresa-id {
            font-size: 8px;
            color: #64748b;
            margin: 0;
        }

        /* Summary */
        .summary {
            background: #eff6ff;
            padding: 12px 15px;
            border-radius: 8px;
            margin-top: 20px;
            border-left: 4px solid #3b82f6;
        }

        .summary-content {
            font-size: 9px;
            color: #1e40af;
            line-height: 1.6;
        }

        .summary-content strong {
            font-weight: 700;
            color: #1e3a8a;
        }

        /* Footer */
        .footer {
            width: 100%;
            background: #f8fafc;
            border-top: 2px solid #e2e8f0;
            padding: 10px 0;
            font-size: 8px;
            color: #64748b;
            margin-top: 30px;
            text-align: center;
        }

        .footer-brand {
            font-weight: 600;
            color: #4f46e5;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 40px 20px;
            background: #f8fafc;
            border-radius: 10px;
            border: 2px dashed #cbd5e1;
        }

        .empty-state-icon {
            font-size: 40px;
            color: #cbd5e1;
            margin-bottom: 15px;
        }

        .empty-state-text {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <table class="header">
        <tr>
            <td class="header-logo">
                <img src="{{ public_path('images/cesrhv.png') }}" alt="CESRH Logo">
            </td>
            <td class="header-info">
                <h1>Listado de Departamentos Registrados</h1>
                <p class="header-meta">Reporte generado el: {{ now()->format('d/m/Y H:i') }}</p>
            </td>
        </tr>
    </table>

    {{-- Información de filtros --}}
    <div class="filters-bar">
        <strong>Filtros aplicados:</strong>
        <span>
            {{ $busqueda || $filtroEmpresa || $filtroEstado ? 
                ($busqueda ? "Búsqueda: \"$busqueda\"" : '') . 
                ($filtroEmpresa ? " • Empresa: $filtroEmpresa" : '') . 
                ($filtroEstado ? " • Estado: " . ucfirst($filtroEstado) : '') 
                : 'Todos los registros' 
            }}
        </span>
    </div>

    <div class="section-title">Detalle de Departamentos</div>

    {{-- Card de departamento --}}
    @forelse ($departamentos as $departamento)
    <table class="departamento-card">
        {{-- Header de la card --}}
        <tr class="card-header">
            <td class="card-avatar-cell">
                <div class="card-avatar">
                    {{ strtoupper(substr($departamento->nombre_departamento, 0, 2)) }}
                </div>
            </td>
            <td>
                <h3 class="card-title">{{ $departamento->nombre_departamento }}</h3>
                <p class="card-id">ID: #{{ $departamento->id_departamento }}</p>
            </td>
            <td class="card-status-cell">
                <span class="card-status badge-{{ strtolower($departamento->estado) }}">
                    {{ ucfirst($departamento->estado) }}
                </span>
            </td>
        </tr>

        {{-- Body de la card --}}
        <tr>
            <td colspan="3" class="card-body">
                {{-- Descripción --}}
                @if($departamento->descripcion)
                <div class="description-box">
                    <div class="info-label">Descripción</div>
                    <div class="info-value">{{ $departamento->descripcion }}</div>
                </div>
                @endif

                {{-- Información en tabla --}}
                <table class="info-table">
                    <tr>
                        <td>
                            <div class="info-label">Puesto Principal</div>
                            <div class="info-value">{{ $departamento->puesto ?? 'N/A' }}</div>
                        </td>
                        <td>
                            <div class="info-label">Fecha de Registro</div>
                            <div class="info-value">
                                {{ $departamento->fecha_registro_departamento ? $departamento->fecha_registro_departamento->format('d/m/Y') : 'N/A' }}
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- Footer de la card (Empresa) --}}
        <tr class="card-footer">
            <td class="empresa-logo-cell">
                @if($departamento->empresa && $departamento->empresa->logo && file_exists(public_path('storage/' . $departamento->empresa->logo)))
                    <img src="{{ public_path('storage/' . $departamento->empresa->logo) }}" 
                         alt="Logo" class="empresa-logo">
                @else
                    <div class="empresa-placeholder">
                        {{ $departamento->empresa ? strtoupper(substr($departamento->empresa->nombre_comercial, 0, 2)) : 'N/A' }}
                    </div>
                @endif
            </td>
            <td colspan="2">
                <p class="empresa-name">{{ $departamento->empresa->nombre_comercial ?? 'No asignada' }}</p>
                @if($departamento->empresa)
                <p class="empresa-id">ID Empresa: {{ $departamento->empresa->id_empresa }}</p>
                @endif
            </td>
        </tr>
    </table>
    @empty
    <div class="empty-state">
        <div class="empty-state-icon">📋</div>
        <p class="empty-state-text">No se encontraron departamentos con los filtros aplicados.</p>
    </div>
    @endforelse

    {{-- Resumen --}}
    @if($departamentos->count() > 0)
    <div class="summary">
        <div class="summary-content">
            <strong>Resumen del reporte:</strong> 
            Se encontraron {{ $departamentos->count() }} departamento(s) registrado(s). • 
            <strong>Generado por:</strong> {{ auth()->user()->name ?? 'Sistema' }}
        </div>
    </div>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <span class="footer-brand">CESRH Consultoría y Coaching</span> • 
        {{ now()->format('d/m/Y') }} • 
        Confidencial
    </div>

</body>
</html>