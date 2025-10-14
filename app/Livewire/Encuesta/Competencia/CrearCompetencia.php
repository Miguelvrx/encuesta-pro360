<?php

namespace App\Livewire\Encuesta\Competencia;

use App\Models\Categoria;
use App\Models\CategoriaCompetencia;
use App\Models\Competencia;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CrearCompetencia extends Component
{
 // Propiedades para la competencia principal
    public ?int $categoria_id_competencia = null;
    public string $nombre_competencia = '';
    public string $definicion_competencia = '';

    // Array para manejar los 5 niveles fijos
    public array $niveles = [];

    // Escala de niveles
    public array $escalaDeNiveles = [
        5 => ['nombre' => 'Excepcional', 'tagline' => 'Modelo a seguir con impacto sostenido'],
        4 => ['nombre' => 'Supera las Expectativas', 'tagline' => 'Desempeño consistentemente superior'],
        3 => ['nombre' => 'Competente', 'tagline' => 'Cumple de forma confiable lo esperado'],
        2 => ['nombre' => 'En Desarrollo', 'tagline' => 'Avanza con áreas por fortalecer'],
        1 => ['nombre' => 'Requiere Apoyo', 'tagline' => 'Necesita acompañamiento para el estándar'],
    ];

    // Catálogo de competencias por categoría
    public array $catalogoCompetencias = [
        'Generales / Organizacionales' => [
            'Comunicación efectiva' => 'Capacidad para transmitir información de manera clara, oportuna y efectiva, adaptándose al contexto y al interlocutor.',
            'Trabajo en equipo' => 'Habilidad para colaborar con otros, compartir conocimientos y contribuir al logro de objetivos comunes.',
            'Respeto' => 'Valoración y consideración hacia las personas, sus opiniones y diferencias, promoviendo un ambiente de convivencia positivo.',
            'Ética' => 'Actuar con integridad, honestidad y transparencia, alineado a los valores y principios organizacionales.',
            'Compromiso' => 'Dedicación y responsabilidad con las tareas asignadas, demostrando lealtad y pertenencia a la organización.',
            'Adaptabilidad' => 'Capacidad para ajustarse a cambios, nuevas situaciones y desafíos con flexibilidad y resiliencia.',
        ],
        'Cardinales / Esenciales' => [
            'Liderazgo' => 'Capacidad para inspirar, guiar y movilizar a otros hacia el logro de objetivos, generando confianza y compromiso.',
            'Orientación a resultados' => 'Enfoque en el cumplimiento de metas y objetivos con eficiencia, calidad y en los plazos establecidos.',
            'Toma de decisiones' => 'Habilidad para analizar información, evaluar alternativas y elegir la mejor opción en situaciones diversas.',
            'Pensamiento estratégico' => 'Capacidad para visualizar el panorama general, anticipar escenarios y planificar acciones a largo plazo.',
        ],
        'Gerenciales / Liderazgo' => [
            'Desarrollo de personas' => 'Compromiso con el crecimiento profesional del equipo, brindando retroalimentación, coaching y oportunidades de aprendizaje.',
            'Influencia' => 'Capacidad para persuadir y generar impacto positivo en otros, logrando apoyo y colaboración.',
            'Gestión del cambio' => 'Habilidad para conducir procesos de transformación, minimizando resistencias y facilitando la adaptación.',
            'Liderar con el ejemplo' => 'Modelar comportamientos deseados, siendo coherente entre lo que se dice y se hace, inspirando a otros.',
        ],
        'Por Área / Específicas' => [
            'Dominio técnico (TI, Ventas, Finanzas)' => 'Conocimiento especializado y aplicación efectiva de herramientas, metodologías y prácticas del área.',
            'Solución de problemas' => 'Capacidad para identificar, analizar y resolver situaciones complejas de manera efectiva y creativa.',
            'Innovación' => 'Habilidad para proponer y implementar ideas nuevas que generen valor y mejoras en procesos, productos o servicios.',
            'Calidad' => 'Compromiso con la excelencia, asegurando que los entregables cumplan o superen los estándares establecidos.',
        ],
        'Educación / Formación' => [
            'Autoconocimiento' => 'Capacidad para reconocer fortalezas, áreas de oportunidad, emociones y su impacto en el desempeño.',
            'Empatía' => 'Habilidad para comprender y conectar con las emociones y perspectivas de otros, generando relaciones significativas.',
            'Facilitación del aprendizaje' => 'Capacidad para diseñar y conducir experiencias de aprendizaje efectivas, adaptadas a las necesidades del grupo.',
            'Evaluación pedagógica' => 'Habilidad para diseñar, aplicar y analizar instrumentos de evaluación que midan el logro de objetivos de aprendizaje.',
        ],
    ];

    // Propiedades para las listas
    public $categorias = [];
    public $competenciasDisponibles = [];

    public function mount(): void
    {
        $this->categorias = Categoria::orderBy('categoria')->get();

        // Inicializamos los 5 niveles
        foreach (array_reverse($this->escalaDeNiveles, true) as $numero => $data) {
            $this->niveles[] = [
                'numero' => $numero,
                'nombre_nivel' => $data['nombre'],
                'tagline' => $data['tagline'],
                'descripcion_nivel' => ''
            ];
        }
    }

    // Actualizar competencias disponibles cuando cambia la categoría
    public function updatedCategoriaIdCompetencia($value): void
    {
        $this->nombre_competencia = '';
        $this->definicion_competencia = '';
        $this->competenciasDisponibles = [];

        if ($value) {
            $categoria = Categoria::find($value);
            if ($categoria && isset($this->catalogoCompetencias[$categoria->categoria])) {
                $this->competenciasDisponibles = array_keys($this->catalogoCompetencias[$categoria->categoria]);
            }
        }
    }

    // Autocompletar definición cuando se selecciona una competencia
    public function updatedNombreCompetencia($value): void
    {
        if ($value && $this->categoria_id_competencia) {
            $categoria = Categoria::find($this->categoria_id_competencia);
            if ($categoria && isset($this->catalogoCompetencias[$categoria->categoria][$value])) {
                $this->definicion_competencia = $this->catalogoCompetencias[$categoria->categoria][$value];
            }
        }
    }

    protected function rules(): array
    {
        return [
            'categoria_id_competencia' => 'required|integer|exists:categoria_competencias,id_categoria_competencia',
            'nombre_competencia' => [
                'required',
                'string',
                'max:255',
                // Validación personalizada para verificar duplicados
                function ($attribute, $value, $fail) {
                    $existe = Competencia::where('nombre_competencia', $value)
                        ->where('categoria_id_competencia', $this->categoria_id_competencia)
                        ->exists();
                    
                    if ($existe) {
                        $fail('Esta competencia ya existe en la categoría seleccionada.');
                    }
                },
            ],
            'definicion_competencia' => 'required|string',
            'niveles.*.nombre_nivel' => 'required|string|max:255',
            'niveles.*.descripcion_nivel' => 'required|string',
        ];
    }

    protected $validationAttributes = [
        'categoria_id_competencia' => 'categoría',
        'nombre_competencia' => 'nombre de la competencia',
        'definicion_competencia' => 'definición de la competencia',
        'niveles.*.nombre_nivel' => 'nombre del nivel',
        'niveles.*.descripcion_nivel' => 'descripción del nivel',
    ];

    public function save(): void
    {
        $this->validate();

        DB::transaction(function () {
            $competencia = Competencia::create([
                'nombre_competencia' => $this->nombre_competencia,
                'definicion_competencia' => $this->definicion_competencia,
                'categoria_id_competencia' => $this->categoria_id_competencia,
            ]);

            foreach ($this->niveles as $nivel) {
                $competencia->niveles()->create([
                    'nombre_nivel' => $nivel['nombre_nivel'],
                    'descripcion_nivel' => $nivel['descripcion_nivel'],
                ]);
            }
        });

        session()->flash('message', '¡Competencia creada exitosamente!');
        $this->redirect(route('revisar-competencia'), navigate: true);
    }

    public function render()
    {
        return view('livewire.encuesta.competencia.crear-competencia')->layout('layouts.app');
    }
}
