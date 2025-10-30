
<?php if (isset($component)) { $__componentOriginalaa758e6a82983efcbf593f765e026bd9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa758e6a82983efcbf593f765e026bd9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::message'),'data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    # Invitación a Evaluación 360°

    Hola <?php echo new \Illuminate\Support\EncodedHtmlString($evaluador->name); ?>,

    Has sido seleccionado para participar en la evaluación 360° de **<?php echo new \Illuminate\Support\EncodedHtmlString($evaluado->name); ?> <?php echo new \Illuminate\Support\EncodedHtmlString($evaluado->primer_apellido); ?>**.

    **Detalles de la evaluación:**
    - **Tipo de evaluación:** <?php echo new \Illuminate\Support\EncodedHtmlString($evaluacion->tipo_evaluacion); ?>

    - **Persona a evaluar:** <?php echo new \Illuminate\Support\EncodedHtmlString($evaluado->name); ?> <?php echo new \Illuminate\Support\EncodedHtmlString($evaluado->primer_apellido); ?>

    - **Tu rol:** <?php echo new \Illuminate\Support\EncodedHtmlString($tipoRol); ?>

    - **Período de evaluación:** <?php echo new \Illuminate\Support\EncodedHtmlString($evaluacion->fecha_inicio->format('d M Y')); ?> - <?php echo new \Illuminate\Support\EncodedHtmlString($evaluacion->fecha_cierre->format('d M Y')); ?>


    <?php if (isset($component)) { $__componentOriginal15a5e11357468b3880ae1300c3be6c4f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15a5e11357468b3880ae1300c3be6c4f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => $__env->getContainer()->make(Illuminate\View\Factory::class)->make('mail::button'),'data' => ['url' => route('realizar-evaluacion', ['uuid' => $evaluacion->uuid_encuesta])]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('mail::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['url' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('realizar-evaluacion', ['uuid' => $evaluacion->uuid_encuesta]))]); ?>
        Comenzar Evaluación
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal15a5e11357468b3880ae1300c3be6c4f)): ?>
<?php $attributes = $__attributesOriginal15a5e11357468b3880ae1300c3be6c4f; ?>
<?php unset($__attributesOriginal15a5e11357468b3880ae1300c3be6c4f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal15a5e11357468b3880ae1300c3be6c4f)): ?>
<?php $component = $__componentOriginal15a5e11357468b3880ae1300c3be6c4f; ?>
<?php unset($__componentOriginal15a5e11357468b3880ae1300c3be6c4f); ?>
<?php endif; ?>

    **Instrucciones:**
    1. Haz clic en el botón "Comenzar Evaluación"
    2. Completa todas las secciones de la evaluación
    3. Envía tus respuestas antes de la fecha de cierre

    Si tienes alguna pregunta, por favor contacta al administrador del sistema.

    Saludos cordiales,<br>
    Equipo de Evaluación 360°
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $attributes = $__attributesOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__attributesOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa758e6a82983efcbf593f765e026bd9)): ?>
<?php $component = $__componentOriginalaa758e6a82983efcbf593f765e026bd9; ?>
<?php unset($__componentOriginalaa758e6a82983efcbf593f765e026bd9); ?>
<?php endif; ?><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/emails/evaluacion-asignada.blade.php ENDPATH**/ ?>