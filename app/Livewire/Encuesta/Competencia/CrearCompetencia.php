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
    public string $nombre_competencia = '';
    public string $definicion_competencia = '';
    public ?int $categoria_id_competencia = null;

    // --- INICIO DE LA SOLUCIÓN ---

    // 1. Array para manejar los 5 niveles fijos
    public array $niveles = [];

    // Definimos la nueva escala completa, con número y descripción corta.
    //    Usamos el número como clave para facilitar el acceso.
    public array $escalaDeNiveles = [
        5 => ['nombre' => 'Excepcional', 'tagline' => 'Modelo a seguir con impacto sostenido'],
        4 => ['nombre' => 'Supera las Expectativas', 'tagline' => 'Desempeño consistentemente superior'],
        3 => ['nombre' => 'Competente', 'tagline' => 'Cumple de forma confiable lo esperado'],
        2 => ['nombre' => 'En Desarrollo', 'tagline' => 'Avanza con áreas por fortalecer'],
        1 => ['nombre' => 'Requiere Apoyo', 'tagline' => 'Necesita acompañamiento para el estándar'],
    ];


    // Propiedades para las listas de los selectores
    public $categorias = [];

    public function mount(): void
    {
        $this->categorias = Categoria::orderBy('categoria')->get();

        // 2. Inicializamos los 5 niveles usando la nueva escala.
        //    Iteramos en orden descendente para que aparezcan del 5 al 1 en el formulario.
        foreach (array_reverse($this->escalaDeNiveles, true) as $numero => $data) {
            $this->niveles[] = [
                'numero' => $numero,
                'nombre_nivel' => $data['nombre'],
                'tagline' => $data['tagline'],
                'descripcion_nivel' => ''
            ];
        }
    }

    // 4. Ya no necesitamos añadirNivel() ni eliminarNivel(), por lo que se eliminan.

    protected function rules(): array
    {
        return [
            'nombre_competencia' => 'required|string|max:255',
            'definicion_competencia' => 'required|string',
            'categoria_id_competencia' => 'required|integer|exists:categoria_competencias,id_categoria_competencia',
            'niveles.*.nombre_nivel' => 'required|string|max:255',
            'niveles.*.descripcion_nivel' => 'required|string',
        ];
    }

    protected $validationAttributes = [
        'nombre_competencia' => 'nombre de la competencia',
        'definicion_competencia' => 'definición de la competencia',
        'categoria_id_competencia' => 'categoría',
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
                    // Opcional: Si tienes una columna para el número/valor, la guardarías aquí.
                    // 'valor' => $nivel['numero'],
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
