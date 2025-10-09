<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Usuarios</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9px;
            color: #333;
        }

        .header-table {
            width: 100%;
            border-bottom: 1px solid #003366;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .header-logo {
            width: 80px;
            text-align: left;
        }

        .header-logo img {
            max-width: 70px;
            max-height: 70px;
        }

        .header-text {
            text-align: right;
            vertical-align: middle;
        }

        .header-text h1 {
            font-size: 16px;
            margin: 0;
            color: #003366;
        }

        .header-text p {
            font-size: 11px;
            margin: 5px 0;
            color: #666;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .main-table th,
        .main-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        .main-table thead {
            background-color: #f2f2f2;
        }

        .main-table th {
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #999;
        }

        .page-number:before {
            content: "Página " counter(page);
        }
    </style>
</head>

<body>

    <table class="header-table">
        <tr>
            <td class="header-logo">
                <img src="{{ public_path('images/cesrhv.png') }}" alt="Logo">
            </td>
            <td class="header-text">
                <h1>Listado de Usuarios</h1>
                {{-- El título del reporte puede ser dinámico --}}
                <p>{{ $tituloReporte ?? 'Reporte General' }}</p>
                <p>Generado el: {{ now()->format('d/m/Y H:i') }}</p>
            </td>
        </tr>
    </table>

    <table class="main-table">
        <thead>
            <tr>
                <th>Nombre Completo</th>
                <th>Email</th>
                <th>Empresa / Depto.</th>
                <th>Puesto</th>
                <th>Rol</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->name }} {{ $usuario->primer_apellido }}</td>
                <td>{{ $usuario->email }}</td>
                <td>
                    <strong>{{ $usuario->departamento->empresa->nombre_comercial ?? 'N/A' }}</strong>

                    <small>{{ $usuario->departamento->nombre_departamento ?? 'N/A' }}</small>
                </td>
                <td>{{ $usuario->puesto }}</td>
                <td>{{ $usuario->rol == 2 ? 'Admin' : 'Usuario' }}</td>
                <td>{{ ucfirst($usuario->estado) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No se encontraron usuarios.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <span class="page-number"></span>
    </div>

</body>

</html>