<?php

namespace App\Livewire\Encuesta\Competencia;

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

    // Array para manejar dinámicamente los niveles
    public array $niveles = [];

    // Propiedades para las listas de los selectores
    public $categorias = [];

    public function mount(): void
    {
        // Cargar las categorías para el selector
        $this->categorias = CategoriaCompetencia::orderBy('categoria')->get();
        // Inicializar con un nivel vacío para que el usuario empiece
        $this->añadirNivel();
    }

    // Función para añadir un nuevo bloque de nivel al formulario
    public function añadirNivel(): void
    {
        $this->niveles[] = ['nombre_nivel' => '', 'descripcion_nivel' => ''];
    }

    // Función para eliminar un bloque de nivel del formulario
    public function eliminarNivel(int $index): void
    {
        unset($this->niveles[$index]);
        $this->niveles = array_values($this->niveles); // Re-indexar el array
    }

    protected function rules(): array
    {
        return [
            'nombre_competencia' => 'required|string|max:255',
            'definicion_competencia' => 'required|string',
            'categoria_id_competencia' => 'required|integer|exists:categoria_competencias,id_categoria_competencia',
            // Validar cada uno de los niveles en el array
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

        // Usamos una transacción para asegurar que todo se guarde correctamente
        DB::transaction(function () {
            // 1. Crear la competencia principal
            $competencia = Competencia::create([
                'nombre_competencia' => $this->nombre_competencia,
                'definicion_competencia' => $this->definicion_competencia,
                'categoria_id_competencia' => $this->categoria_id_competencia,
            ]);

            // 2. Crear cada uno de los niveles y asociarlos a la competencia
            foreach ($this->niveles as $nivel) {
                $competencia->niveles()->create([
                    'nombre_nivel' => $nivel['nombre_nivel'],
                    'descripcion_nivel' => $nivel['descripcion_nivel'],
                ]);
            }
        });

        session()->flash('message', '¡Competencia creada exitosamente!');
        $this->redirect(route('crear-competencia'), navigate: true);
    }


    public function render()
    {
        return view('livewire.encuesta.competencia.crear-competencia')->layout('layouts.app');
    }
}
