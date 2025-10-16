<?php

namespace App\Livewire\Encuesta\Evaluacion;

use App\Mail\EvaluacionAsignada;
use App\Models\Categoria;
use App\Models\Competencia;
use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class CrearEvaluacion extends Component
{
    public $evaluacion_id;
    public $paso_actual = 1;

    // Paso 1: Información Básica
    public $tipo_evaluacion = "";
    public $fecha_inicio = "";
    public $fecha_cierre = "";
    public $descripcion_evaluacion = "";
    // En la clase CrearEvaluacion, agrega esta propiedad
    public $evaluadoresDisponibles;

    // Paso 2: Configuración - Competencias seleccionadas
    public $categoriaSeleccionada = null;
    public $competenciasSeleccionadas = []; // IDs de competencias seleccionadas

    // Paso 3: Encuestados
    public $encuestadoSeleccionado = null;
    public $encuestados = []; // Array de personas evaluadas

    // New properties for filtering
    public $empresaSeleccionada = '';
    public $departamentoSeleccionado = '';
    public $departamentos = []; // To store departments for the selected company

    // Paso 4: Calificadores
    public $calificadores = []; // Array con asignaciones de calificadores por encuestado
    public $calificadorTempSeleccionado = [];
    public $tipoRolTempSeleccionado = [];

    // Datos para selects
    public $categorias;
    public $competenciasPorCategoria;
    public $usuarios;
    public $empresas; // To store all companies

    // Y actualiza el método mount
    public function mount($id = null)
    {
        // Cargar datos para los selects
        $this->categorias = Categoria::orderBy('categoria')->get();
        $this->empresas = Empresa::orderBy('nombre_comercial')->get();
        $this->departamentos = collect();
        $this->usuarios = collect();
        $this->competenciasPorCategoria = collect();
        $this->evaluadoresDisponibles = collect(); // Inicializar

        if ($id) {
            $this->evaluacion_id = $id;
            $this->cargarEvaluacionExistente();
        } else {
            $this->fecha_inicio = now()->format("Y-m-d");
            $this->fecha_cierre = now()->addMonth()->format("Y-m-d");
            $this->calificadores = [];
        }

        $this->actualizarUsuarios();
        $this->evaluadoresDisponibles = $this->obtenerEvaluadoresDisponibles(); // Cargar evaluadores
    }


    // Método para actualizar evaluadores cuando cambien los filtros (opcional)
    public function updatedEmpresaSeleccionada($value)
    {
        $this->departamentoSeleccionado = '';
        if ($value) {
            $this->departamentos = Departamento::where('empresa_id_empresa', $value)
                ->orderBy('nombre_departamento')
                ->get();
        } else {
            $this->departamentos = collect();
        }
        $this->actualizarUsuarios(); // Para Paso 3

        // También actualizar evaluadores si quieres mantener los mismos filtros
        if ($this->paso_actual == 4) {
            $this->evaluadoresDisponibles = $this->obtenerEvaluadoresDisponibles();
        }
    }

    public function updatedDepartamentoSeleccionado()
    {
        $this->actualizarUsuarios(); // Para Paso 3

        // También actualizar evaluadores si quieres mantener los mismos filtros
        if ($this->paso_actual == 4) {
            $this->evaluadoresDisponibles = $this->obtenerEvaluadoresDisponibles();
        }
    }

    // Helper method to update user list based on filters
    private function actualizarUsuarios()
    {
        $query = User::where('estado', 'activo')->orderBy('name');

        if ($this->empresaSeleccionada) {
            $query->whereHas('departamento.empresa', function ($q) {
                $q->where('id_empresa', $this->empresaSeleccionada);
            });
        }

        if ($this->departamentoSeleccionado) {
            $query->where('departamento_id', $this->departamentoSeleccionado);
        }

        $this->usuarios = $query->get();
    }

    // Nuevo método para obtener usuarios disponibles como evaluadores (para Paso 4)
    private function obtenerEvaluadoresDisponibles()
    {
        // Si hay un encuestado seleccionado, filtrar por su misma empresa
        if (count($this->encuestados) > 0) {
            $encuestado = $this->encuestados[0]; // Tomamos el primer encuestado

            // Obtener la empresa del encuestado
            $empresaEncuestado = User::find($encuestado['id'])->departamento->empresa_id_empresa ?? null;

            if ($empresaEncuestado) {
                // Filtrar usuarios de la misma empresa
                return User::where('estado', 'activo')
                    ->whereHas('departamento', function ($query) use ($empresaEncuestado) {
                        $query->where('empresa_id_empresa', $empresaEncuestado);
                    })
                    ->orderBy('name')
                    ->get();
            }
        }

        // Si no hay encuestado o no tiene empresa, cargar todos los usuarios
        return User::where('estado', 'activo')
            ->orderBy('name')
            ->get();
    }

    protected function cargarEvaluacionExistente()
    {
        $evaluacion = Evaluacion::find($this->evaluacion_id);

        if ($evaluacion) {
            $this->paso_actual = $evaluacion->paso_actual;
            $this->tipo_evaluacion = $evaluacion->tipo_evaluacion;
            $this->fecha_inicio = $evaluacion->fecha_inicio->format('Y-m-d');
            $this->fecha_cierre = $evaluacion->fecha_cierre->format('Y-m-d');
            $this->descripcion_evaluacion = $evaluacion->descripcion_evaluacion;
            $this->competenciasSeleccionadas = $evaluacion->configuracion_data['competencias'] ?? [];
            $this->encuestados = $evaluacion->encuestados_data ?? [];
            $this->calificadores = $evaluacion->calificadores_data ?? [];
        }
    }

    // PASO 2: Cargar competencias cuando se selecciona categoría
    public function updatedCategoriaSeleccionada($value)
    {
        if ($value) {
            $this->competenciasPorCategoria = Competencia::with(['niveles', 'preguntas'])
                ->where('categoria_id_competencia', $value)
                ->orderBy('nombre_competencia')
                ->get();
        } else {
            $this->competenciasPorCategoria = collect();
        }
    }

    // PASO 2: Toggle competencia seleccionada
    public function toggleCompetencia($competenciaId)
    {
        if (in_array($competenciaId, $this->competenciasSeleccionadas)) {
            $this->competenciasSeleccionadas = array_values(
                array_filter($this->competenciasSeleccionadas, fn($id) => $id != $competenciaId)
            );
        } else {
            $this->competenciasSeleccionadas[] = $competenciaId;
        }

        // Guardado automático
        $this->guardarPasoSilencioso();
    }

    // En el método seleccionarEncuestado, agregar autoevaluación automática
    public function seleccionarEncuestado($usuarioId)
    {
        $usuario = User::find($usuarioId);

        if (!$usuario) return;

        // Limpiar encuestados anteriores (solo permitir uno)
        $this->encuestados = [];
        $this->calificadores = [];

        $encuestadoData = [
            'id' => $usuario->id,
            'nombre' => $usuario->name . ' ' . $usuario->primer_apellido . ($usuario->segundo_apellido ? ' ' . $usuario->segundo_apellido : ''),
            'email' => $usuario->email,
            'puesto' => $usuario->puesto,
            'empresa' => $usuario->departamento->empresa->nombre_comercial ?? 'N/A',
            'departamento' => $usuario->departamento->nombre_departamento ?? 'N/A',
        ];

        $this->encuestados[] = $encuestadoData;

        // Agregar autoevaluación automáticamente
        $this->calificadores[0] = [[
            'id' => $usuario->id,
            'nombre' => $encuestadoData['nombre'],
            'email' => $encuestadoData['email'],
            'tipo_rol' => 'Autoevaluación',
        ]];

        // Actualizar evaluadores disponibles (solo de la misma empresa)
        $this->evaluadoresDisponibles = $this->obtenerEvaluadoresDisponibles();

        // Guardado automático
        $this->guardarPasoSilencioso();
        session()->flash('message', 'Colaborador seleccionado exitosamente. La autoevaluación se ha agregado automáticamente.');
    }

    // PASO 3: Agregar encuestado
    public function agregarEncuestado()
    {
        if (!$this->encuestadoSeleccionado) return;

        $usuario = User::find($this->encuestadoSeleccionado);

        if (!$usuario) return;

        // Evitar duplicados
        $existe = collect($this->encuestados)->firstWhere('id', $usuario->id);
        if ($existe) {
            session()->flash('error', 'Este usuario ya está agregado como encuestado.');
            return;
        }

        $this->encuestados[] = [
            'id' => $usuario->id,
            'nombre' => $usuario->name . ' ' . $usuario->primer_apellido . ($usuario->segundo_apellido ? ' ' . $usuario->segundo_apellido : ''),
            'email' => $usuario->email,
            'puesto' => $usuario->puesto,
            // Opcional: agregar empresa y departamento si los quieres mostrar en la tarjeta
            'empresa' => $usuario->departamento->empresa->nombre_comercial ?? 'N/A',
            'departamento' => $usuario->departamento->nombre_departamento ?? 'N/A',
        ];

        $this->encuestadoSeleccionado = null;

        // Guardado automático
        $this->guardarPasoSilencioso();
        session()->flash('message', 'Encuestado agregado exitosamente.');
    }

    // PASO 3: Eliminar encuestado
    public function eliminarEncuestado($index)
    {
        unset($this->encuestados[$index]);
        $this->encuestados = array_values($this->encuestados);

        // También eliminar sus calificadores
        if (isset($this->calificadores[$index])) {
            unset($this->calificadores[$index]);
            $this->calificadores = array_values($this->calificadores);
        }

        $this->guardarPasoSilencioso();
        session()->flash('message', 'Encuestado eliminado.');
    }

    // Modificar el método eliminarCalificador para proteger la autoevaluación
    public function eliminarCalificador($encuestadoIndex, $calificadorIndex)
    {
        if (isset($this->calificadores[$encuestadoIndex][$calificadorIndex])) {
            // Prevenir eliminación de autoevaluación
            if ($this->calificadores[$encuestadoIndex][$calificadorIndex]['tipo_rol'] === 'Autoevaluación') {
                session()->flash('error', 'La autoevaluación no puede eliminarse.');
                return;
            }

            unset($this->calificadores[$encuestadoIndex][$calificadorIndex]);
            $this->calificadores[$encuestadoIndex] = array_values($this->calificadores[$encuestadoIndex]);

            $this->guardarPasoSilencioso();
            session()->flash('message', 'Evaluador eliminado.');
        }
    }


    // Modificar el método agregarCalificador para evitar duplicar autoevaluación
    public function agregarCalificador($encuestadoIndex)
    {
        $calificadorId = $this->calificadorTempSeleccionado[$encuestadoIndex] ?? null;
        $tipoRol = $this->tipoRolTempSeleccionado[$encuestadoIndex] ?? null;

        if (!$calificadorId || !$tipoRol) {
            session()->flash('error', 'Debes seleccionar un evaluador y un tipo de relación.');
            return;
        }

        $calificador = User::find($calificadorId);
        if (!$calificador) {
            session()->flash('error', 'Evaluador no encontrado.');
            return;
        }

        if (!isset($this->calificadores[$encuestadoIndex])) {
            $this->calificadores[$encuestadoIndex] = [];
        }

        // Evitar duplicados (incluyendo autoevaluación)
        $existe = collect($this->calificadores[$encuestadoIndex])->firstWhere('id', $calificador->id);
        if ($existe) {
            session()->flash('error', 'Este evaluador ya está asignado a este colaborador.');
            return;
        }

        // Evitar que se agregue autoevaluación manualmente
        if ($calificadorId == $this->encuestados[$encuestadoIndex]['id']) {
            session()->flash('error', 'La autoevaluación se incluye automáticamente.');
            return;
        }

        $this->calificadores[$encuestadoIndex][] = [
            'id' => $calificador->id,
            'nombre' => $calificador->name . ' ' . ($calificador->primer_apellido ?? ''),
            'email' => $calificador->email,
            'tipo_rol' => $tipoRol,
        ];

        // Limpiar los campos temporales
        $this->calificadorTempSeleccionado[$encuestadoIndex] = null;
        $this->tipoRolTempSeleccionado[$encuestadoIndex] = null;

        $this->guardarPasoSilencioso();
        session()->flash('message', 'Evaluador agregado exitosamente.');
    }

    // Guardado automático silencioso (sin redirección ni mensaje)
    protected function guardarPasoSilencioso()
    {
        $data = [
            'tipo_evaluacion' => $this->tipo_evaluacion,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_cierre' => $this->fecha_cierre,
            'descripcion_evaluacion' => $this->descripcion_evaluacion,
            'configuracion_data' => [
                'competencias' => $this->competenciasSeleccionadas
            ],
            'encuestados_data' => $this->encuestados,
            'calificadores_data' => $this->calificadores,
            'estado' => 'borrador',
            'paso_actual' => $this->paso_actual,
        ];

        if ($this->evaluacion_id) {
            Evaluacion::find($this->evaluacion_id)->update($data);
        } else {
            $data['uuid_encuesta'] = (string) Str::uuid();
            $evaluacion = Evaluacion::create($data);
            $this->evaluacion_id = $evaluacion->id_evaluacion;
        }
    }

    // Validación y guardado con mensaje
    protected function guardarPaso()
    {
        $this->validatePaso($this->paso_actual);
        $this->guardarPasoSilencioso();
        session()->flash('message', 'Paso guardado exitosamente.');
    }

    protected function validatePaso($paso)
    {
        $rules = [];

        switch ($paso) {
            case 1:
                $rules = [
                    "tipo_evaluacion" => "required|string|max:100",
                    "fecha_inicio" => "required|date",
                    "fecha_cierre" => "required|date|after_or_equal:fecha_inicio",
                    "descripcion_evaluacion" => "required|string",
                ];
                break;
            case 2:
                $rules = [
                    "competenciasSeleccionadas" => "required|array|min:1",
                ];
                break;
            case 3:
                $rules = [
                    "encuestados" => "required|array|min:1|max:1", // Solo permitir 1 encuestado
                ];
                break;
            case 4:
                // Validar que cada encuestado tenga al menos un calificador
                foreach ($this->encuestados as $index => $encuestado) {
                    if (!isset($this->calificadores[$index]) || count($this->calificadores[$index]) === 0) {
                        throw new \Exception("El encuestado {$encuestado['nombre']} necesita al menos un calificador.");
                    }
                }
                break;
        }

        if (!empty($rules)) {
            $this->validate($rules);
        }
    }

    // Navegación entre pasos
    public function siguientePaso()
    {
        try {
            $this->guardarPaso();

            if ($this->paso_actual < 5) {
                $this->paso_actual++;
            }
        } catch (\Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function anteriorPaso()
    {
        $this->guardarPasoSilencioso();

        if ($this->paso_actual > 1) {
            $this->paso_actual--;
        }
    }

    // Paso 5: Ir a un paso específico desde revisión
    public function irAPaso($paso)
    {
        $this->guardarPasoSilencioso();
        $this->paso_actual = $paso;
    }

    // Paso 5: Envío final
    public function enviarEvaluaciones()
    {
        try {
            $this->validatePaso(4); // Validar que todo esté completo

            $evaluacion = Evaluacion::find($this->evaluacion_id);

            // Crear registros en evaluacion_usuario y enviar correos
            foreach ($this->encuestados as $index => $encuestado) {
                $calificadoresAsignados = $this->calificadores[$index] ?? [];

                foreach ($calificadoresAsignados as $calificador) {
                    // Crear relación en la base de datos
                    $evaluacion->usuarios()->attach($calificador['id'], [
                        'usuario_rol' => $encuestado['id'], // ID del evaluado
                        'tipo_rol' => $calificador['tipo_rol'],
                        'fecha_de_asignacion' => now(),
                        'evaluado' => false,
                    ]);

                    // Enviar correo al calificador
                    $evaluador = User::find($calificador['id']);
                    $evaluado = User::find($encuestado['id']);

                    if ($evaluador && $evaluado) {
                        Mail::to($evaluador->email)
                            ->send(new EvaluacionAsignada($evaluacion, $evaluador, $evaluado, $calificador['tipo_rol']));
                    }
                }
            }

            // Cambiar estado
            $evaluacion->update([
                'estado' => 'completada',
                'paso_actual' => 5
            ]);

            session()->flash('message', '¡Evaluaciones enviadas exitosamente! Se han enviado los correos a todos los evaluadores.');
            return $this->redirect(route('mostrar-evaluaciones'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al enviar evaluaciones: ' . $e->getMessage());
        }
    }

    public function render()
    {
        // Pasar datos diferentes según el paso actual
        $evaluadoresDisponibles = $this->obtenerEvaluadoresDisponibles();

        return view("livewire.encuesta.evaluacion.crear-evaluacion", [
            'evaluadoresDisponibles' => $evaluadoresDisponibles
        ])->layout("layouts.app");
    }
}
