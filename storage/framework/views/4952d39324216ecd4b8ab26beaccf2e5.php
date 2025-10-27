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
            margin: 0;
            padding: 15px;
            background-color: #ffffff;
        }

        /* Header mejorado */
        .header {
            width: 100%;
            border-bottom: 2px solid #003366;
            padding-bottom: 15px;
            margin-bottom: 20px;
            border-collapse: collapse;
        }

        .header-logo {
            width: 60px;
            text-align: left;
            vertical-align: top;
        }

        .header-logo img {
            max-width: 50px;
            max-height: 50px;
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

        /* Información de la empresa */
        .company-info {
            margin-bottom: 15px;
            padding: 8px;
            background-color: #f8fafc;
            border-radius: 4px;
            font-size: 9px;
        }

        /* Tabla principal mejorada */
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 8px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ddd;
            padding: 5px 4px;
            text-align: left;
            vertical-align: top;
            line-height: 1.2;
        }

        .data-table thead {
            background-color: #003366;
        }

        .data-table th {
            font-weight: bold;
            font-size: 8px;
            text-transform: uppercase;
            color: white;
            padding: 6px 4px;
        }

        .data-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* Logo de empresa en PDF */
        .empresa-logo {
            width: 25px;
            height: 25px;
            object-fit: cover;
            border-radius: 3px;
            border: 1px solid #ddd;
            display: block;
        }

        .logo-container {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* Estados mejorados */
        .badge {
            padding: 2px 6px;
            border-radius: 8px;
            font-size: 7px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
            min-width: 40px;
        }

        .badge-activo {
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .badge-inactivo {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }

        .badge-proceso {
            background-color: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }

        .badge-suspendido {
            background-color: #e5e7eb;
            color: #374151;
            border: 1px solid #d1d5db;
        }

        /* Resumen al final */
        .summary {
            margin-top: 15px;
            padding: 8px;
            background-color: #f0f7ff;
            border-radius: 4px;
            font-size: 9px;
            border-left: 3px solid #003366;
        }

        .summary strong {
            color: #003366;
        }

        /* Footer mejorado */
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

        /* Estilos para celdas específicas */
        .rfc-cell {
            font-family: 'Courier New', monospace;
            font-size: 7px;
        }

        .nombre-comercial {
            font-weight: 500;
        }

        .id-cell {
            font-weight: bold;
            color: #003366;
        }

        /* Encabezado de sección */
        .section-title {
            font-size: 11px;
            color: #003366;
            margin: 15px 0 8px 0;
            padding-bottom: 4px;
            border-bottom: 1px solid #e2e8f0;
            font-weight: bold;
        }

        /* Avatar para empresas sin logo */
        .avatar {
            width: 25px;
            height: 25px;
            border-radius: 3px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 8px;
            font-weight: bold;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>

    
    <table class="header">
        <tr>
            <td class="header-logo">
                <img src="<?php echo e(public_path('images/cesrhv.png')); ?>" alt="CESRH Logo" style="width: 90px; height: auto;">
            </td>
            <td class="header-text">
                <h1>Listado de Empresas Registradas</h1>
                <p>Reporte generado el: <?php echo e(now()->format('d/m/Y H:i')); ?></p>
                <p style="font-size: 8px; color: #888; margin-top: 2px;">
                    Sistema de Gestión Empresarial - CESRH
                </p>
            </td>
        </tr>
    </table>

    
    <div class="company-info">
        <strong>Filtros aplicados:</strong> 
        <?php echo e($busqueda ? "Búsqueda: \"$busqueda\" • " : ''); ?>

        <?php echo e($filtroSector ? "Sector: $filtroSector • " : ''); ?>

        <?php echo e($filtroEstado ? "Estado: $filtroEstado" : 'Todos los registros'); ?>

    </div>

    
    <div class="section-title">Detalle de Empresas</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">ID</th>
                <th width="5%">Logo</th>
                <th width="20%">Nombre Comercial</th>
                <th width="15%">RFC</th>
                <th width="12%">Sector</th>
                <th width="18%">Ubicación</th>
                <th width="10%">Registro</th>
                <th width="15%">Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                
                <td class="id-cell"><?php echo e($empresa->id_empresa); ?></td>
                
                
                <td>
                    <div class="logo-container">
                        <?php if($empresa->logo && file_exists(public_path('storage/' . $empresa->logo))): ?>
                            <img src="<?php echo e(public_path('storage/' . $empresa->logo)); ?>" 
                                 alt="Logo" 
                                 class="empresa-logo"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="avatar" style="display: none;">
                                <?php echo e(strtoupper(substr($empresa->nombre_comercial, 0, 2))); ?>

                            </div>
                        <?php else: ?>
                            <div class="avatar">
                                <?php echo e(strtoupper(substr($empresa->nombre_comercial, 0, 2))); ?>

                            </div>
                        <?php endif; ?>
                    </div>
                </td>
                
                
                <td class="nombre-comercial"><?php echo e($empresa->nombre_comercial); ?></td>
                
                
                <td class="rfc-cell"><?php echo e($empresa->rfc); ?></td>
                
                
                <td><?php echo e($empresa->sector); ?></td>
                
                
                <td><?php echo e($empresa->municipio ?? $empresa->ciudad); ?>, <?php echo e($empresa->estado); ?>, <?php echo e($empresa->pais); ?></td>
                
                
                <td><?php echo e($empresa->fecha_registro->format('d/m/Y')); ?></td>
                
                
                <td>
                    <?php
                    $estadoClass = 'badge-suspendido';
                    if ($empresa->estado_inicial == 'Activo') $estadoClass = 'badge-activo';
                    if ($empresa->estado_inicial == 'Inactivo') $estadoClass = 'badge-inactivo';
                    if ($empresa->estado_inicial == 'En Proceso') $estadoClass = 'badge-proceso';
                    ?>
                    <span class="badge <?php echo e($estadoClass); ?>"><?php echo e($empresa->estado_inicial); ?></span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="8" style="text-align: center; padding: 15px; color: #666; font-style: italic;">
                    No se encontraron empresas con los filtros aplicados.
                </td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>

    
    <?php if($empresas->count() > 0): ?>
    <div class="summary">
        <strong>Resumen del reporte:</strong> 
        Se encontraron <?php echo e($empresas->count()); ?> empresa(s) registrada(s)
        <?php if($busqueda || $filtroSector || $filtroEstado): ?>
        con los filtros aplicados
        <?php endif; ?>
        • Generado por: <?php echo e(auth()->user()->name ?? 'Sistema'); ?>

    </div>
    <?php endif; ?>

    
    <div class="footer">
        <span class="page-number"></span> 
        • CESRH Consultoría y Coaching • 
        <?php echo e(now()->format('d/m/Y')); ?> • 
        Confidencial
    </div>

</body>
</html><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/empresas-pdf.blade.php ENDPATH**/ ?>