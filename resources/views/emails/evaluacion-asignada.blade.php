{{-- resources/views/emails/evaluacion-asignada.blade.php --}}
<x-mail::message>
    # Invitación a Evaluación 360°

    Hola {{ $evaluador->name }},

    Has sido seleccionado para participar en la evaluación 360° de **{{ $evaluado->name }} {{ $evaluado->primer_apellido }}**.

    **Detalles de la evaluación:**
    - **Tipo de evaluación:** {{ $evaluacion->tipo_evaluacion }}
    - **Persona a evaluar:** {{ $evaluado->name }} {{ $evaluado->primer_apellido }}
    - **Tu rol:** {{ $tipoRol }}
    - **Período de evaluación:** {{ $evaluacion->fecha_inicio->format('d M Y') }} - {{ $evaluacion->fecha_cierre->format('d M Y') }}

    <x-mail::button :url="route('realizar-evaluacion', ['uuid' => $evaluacion->uuid_encuesta])">
        Comenzar Evaluación
    </x-mail::button>

    **Instrucciones:**
    1. Haz clic en el botón "Comenzar Evaluación"
    2. Completa todas las secciones de la evaluación
    3. Envía tus respuestas antes de la fecha de cierre

    Si tienes alguna pregunta, por favor contacta al administrador del sistema.

    Saludos cordiales,<br>
    Equipo de Evaluación 360°
</x-mail::message>