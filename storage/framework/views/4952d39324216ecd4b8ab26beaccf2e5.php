<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Listado de Empresas</title>
    <style>
        /* Estilos generales */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9px;
            color: #333;
            margin: 0;
            padding: 15px;
        }

        /* --- Estilos del Header, Footer y otros elementos (sin cambios) --- */
        .header {
            width: 100%;
            border-bottom: 2px solid #003366;
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .header-logo {
            width: 200px;
            text-align: left;
            vertical-align: top;
        }

        .header-logo img {
            max-width: 180px;
            height: auto;
            display: block;
        }

        .header-text {
            text-align: right;
            vertical-align: top;
            padding-left: 10px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0 0 5px 0;
            color: #003366;
            font-weight: bold;
        }

        .header p {
            font-size: 9px;
            margin: 0;
            color: #666;
        }

        .company-info {
            margin-bottom: 15px;
            padding: 8px;
            background-color: #f8fafc;
            border-radius: 4px;
            font-size: 9px;
        }

        .section-title {
            font-size: 12px;
            color: #003366;
            margin: 20px 0 10px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: bold;
        }

        .summary {
            margin-top: 15px;
            padding: 8px;
            background-color: #f0f7ff;
            border-radius: 4px;
            font-size: 9px;
            border-left: 3px solid #003366;
        }

        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #666;
            padding: 8px 0;
            background-color: #f8fafc;
            border-top: 1px solid #ddd;
        }

        .page-number:before {
            content: "Página " counter(page);
        }

        /* --- Estructura de Tabla --- */
        .empresa-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .empresa-table td {
            border: 1px solid #ddd;
            padding: 8px;
            vertical-align: top;
        }

        .empresa-table tr.main-info:nth-child(odd) {
            background-color: #ffffff;
        }

        .empresa-table tr.main-info:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Celda del Logo */
        .logo-cell {
            width: 80px;
            text-align: center;
            vertical-align: middle;
        }

        .empresa-logo {
            width: 100px;
            height: auto;
            margin: 0 auto;
            display: block;
        }

        .avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #003366;
            color: white;
            font-size: 22px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }


        /* Celda de Información */
        .info-cell h3 {
            font-size: 11px;
            color: #003366;
            margin: 0 0 8px 0;
            font-weight: bold;
        }

        .info-cell p {
            margin: 0 0 4px 0;
            font-size: 9px;
            line-height: 1.4;
        }

        .info-cell strong {
            font-weight: bold;
            color: #555;
        }

        /* --- NUEVO: Celda de Contacto --- */
        .contact-cell {
            background-color: #f9f9f9;
            padding: 8px;
            font-size: 8.5px;
            border-top: 1px solid #ccc;
        }

        .contact-cell strong {
            font-weight: bold;
            color: #333;
        }

        .contact-cell p {
            margin: 0 0 3px 0;
        }

        /* Badges de estado */
        .badge {
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 8px;
            font-weight: bold;
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
    </style>
</head>

<body>

    
    <table class="header">
        <tr>
            <td class="header-logo"><img src="<?php echo e(public_path('images/cesrhv.png')); ?>" alt="CESRH Logo"></td>
            <td class="header-text">
                <h1>Listado de Empresas Registradas</h1>
                <p>Reporte generado el: <?php echo e(now()->format('d/m/Y H:i')); ?></p>
                <!-- <p style="font-size: 8px; color: #888; margin-top: 2px;">
                    Sistema de Gestión Empresarial - CESRH
                </p> -->
            </td>
        </tr>
    </table>
    <div class="company-info"><strong>Filtros aplicados:</strong> <?php echo e($busqueda || $filtroSector || $filtroEstado ? ($busqueda ? "Búsqueda: \"$busqueda\"" : '') . ($filtroSector ? " • Sector: $filtroSector" : '') . ($filtroEstado ? " • Estado: $filtroEstado" : '') : 'Todos los registros'); ?></div>
    <div class="section-title">Detalle de Empresas</div>

    
    <?php $__empty_1 = true; $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <table class="empresa-table" style="margin-bottom: 15px;">
        <tr class="main-info">
            
            <td class="logo-cell">
                <?php if($empresa->logo && file_exists(public_path('storage/' . $empresa->logo))): ?>
                <img src="<?php echo e(public_path('storage/' . $empresa->logo)); ?>" alt="Logo" class="empresa-logo">
                <?php else: ?>
                <div class="avatar"><span><?php echo e(strtoupper(substr($empresa->nombre_comercial, 0, 2))); ?></span></div>
                <?php endif; ?>
            </td>

            
            <td class="info-cell">
                <h3>(#<?php echo e($empresa->id_empresa); ?>) <?php echo e($empresa->nombre_comercial); ?></h3>
                <p><strong>Razón Social:</strong> <?php echo e($empresa->razon_social ?? 'N/A'); ?></p>
                <p><strong>RFC:</strong> <?php echo e($empresa->rfc ?? 'N/A'); ?></p>
                <p><strong>Dirección:</strong> <?php echo e($empresa->direccion ?? ''); ?>, <?php echo e($empresa->municipio ?? $empresa->ciudad ?? ''); ?>, <?php echo e($empresa->estado ?? ''); ?>. <strong>C.P.</strong> <?php echo e($empresa->codigo_postal ?? 'S/N'); ?></p>
            </td>

            
            <td class="info-cell" style="width: 35%;">
                <p><strong>Estado:</strong> <span class="badge badge-<?php echo e(strtolower($empresa->estado_inicial)); ?>"><?php echo e($empresa->estado_inicial); ?></span></p>
                <p><strong>Sector:</strong> <?php echo e($empresa->sector ?? 'N/A'); ?></p>
                <p><strong>Nº Empleados:</strong> <?php echo e($empresa->numero_empleados ?? 'N/A'); ?></p>
                <p><strong>Año en Mercado:</strong> <?php echo e($empresa->ano_mercado ?? 'N/A'); ?></p>
                <p><strong>Tipo de Org.:</strong> <?php echo e($empresa->tipo_organizacion ?? 'N/A'); ?></p>
                <p><strong>Registro:</strong> <?php echo e($empresa->fecha_registro->format('d/m/Y')); ?></p>
            </td>
        </tr>
        
        
        
        <tr>
            <td class="contact-cell" colspan="3">
                <strong>Contacto Principal:</strong> <?php echo e($empresa->contacto_nombre ?? 'No especificado'); ?>

                <?php if($empresa->contacto_puesto): ?>
                <em>(<?php echo e($empresa->contacto_puesto); ?>)</em>
                <?php endif; ?>
                &nbsp; • &nbsp; <strong>Tel:</strong> <?php echo e($empresa->contacto_telefono ?? 'N/A'); ?>

                &nbsp; • &nbsp; <strong>Email:</strong> <?php echo e($empresa->contacto_correo ?? 'N/A'); ?>

            </td>
        </tr>
    </table>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p style="text-align: center; padding: 20px; background-color: #f8fafc;">No se encontraron empresas con los filtros aplicados.</p>
    <?php endif; ?>

    
    <?php if($empresas->count() > 0): ?>
    <div class="summary"><strong>Resumen del reporte:</strong> Se encontraron <?php echo e($empresas->count()); ?> empresa(s) registrada(s). • Generado por: <?php echo e(auth()->user()->name ?? 'Sistema'); ?></div>
    <?php endif; ?>
    <div class="footer"><span class="page-number"></span> • CESRH Consultoría y Coaching • <?php echo e(now()->format('d/m/Y')); ?> • Confidencial</div>

</body>

</html><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/empresas-pdf.blade.php ENDPATH**/ ?>