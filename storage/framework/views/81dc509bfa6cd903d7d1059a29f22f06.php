<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Empresas</title>
    <style>
        /* Estilos generales para el documento PDF */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 10px;
            color: #333;
        }

        /* ... (otros estilos) ... */

        .header {
            /* Ya no es text-align: center, porque la tabla lo maneja */
            width: 100%;
            border-bottom: 1px solid #003366;
            /* Opcional, para una línea divisoria */
            padding-bottom: 10px;
            margin-bottom: 20px;
            border-collapse: collapse;
            /* Importante para tablas sin bordes visibles */
        }

        .header-logo {
            width: 80px;
            /* Ancho para la celda del logo */
            text-align: left;
        }

        .header-logo img {
            max-width: 70px;
            max-height: 70px;
        }

        .header-text {
            text-align: right;
            /* Alinea el texto a la derecha */
            vertical-align: middle;
            /* Centra verticalmente el texto con el logo */
        }

        /* ... (el resto de tus estilos) ... */


        .header h1 {
            font-size: 18px;
            margin: 0;
            color: #003366;
        }

        .header p {
            font-size: 12px;
            margin: 5px 0;
            color: #666;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            vertical-align: top;
        }

        thead {
            background-color: #f2f2f2;
        }

        th {
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }

        .logo {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border-radius: 50%;
        }

        .badge {
            padding: 3px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            text-align: center;
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

        .badge-proceso {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-suspendido {
            background-color: #e5e7eb;
            color: #374151;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
            color: #999;
        }

        .page-number:before {
            content: "Página " counter(page);
        }
    </style>
</head>

<body>

    
    <table class="header">
        <tr>
            <td class="header-logo">
                <img src="<?php echo e(public_path('images/cesrhv.png')); ?>" alt="Logo de la Empresa">
            </td>
            <td class="header-text">
                <h1>Listado de Empresas Registradas</h1>
                <p>Reporte generado el: <?php echo e(now()->format('d/m/Y H:i')); ?></p>
            </td>
        </tr>
    </table>


    <table>
        <thead>
            <tr>
                <th>Nombre Comercial</th>
                <th>RFC</th>
                <th>Sector</th>
                <th>Ubicación</th>
                <th>Registro</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($empresa->nombre_comercial); ?></td>
                <td><?php echo e($empresa->rfc); ?></td>
                <td><?php echo e($empresa->sector); ?></td>
                <td><?php echo e($empresa->municipio ?? $empresa->ciudad); ?>, <?php echo e($empresa->estado); ?>, <?php echo e($empresa->pais); ?></td>
                <td><?php echo e($empresa->fecha_registro->format('d/m/Y')); ?></td>
                <td>
                    <?php
                    $estadoClass = 'badge-suspendido'; // Default
                    if ($empresa->estado_inicial == 'Activo') $estadoClass = 'badge-activo';
                    if ($empresa->estado_inicial == 'Inactivo') $estadoClass = 'badge-inactivo';
                    if ($empresa->estado_inicial == 'En Proceso') $estadoClass = 'badge-proceso';
                    ?>
                    <span class="badge <?php echo e($estadoClass); ?>"><?php echo e($empresa->estado_inicial); ?></span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="6" style="text-align: center;">No se encontraron empresas con los filtros aplicados.</td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="footer">
        <span class="page-number"></span>
    </div>

</body>

</html><?php /**PATH C:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/empresas-pdf.blade.php ENDPATH**/ ?>