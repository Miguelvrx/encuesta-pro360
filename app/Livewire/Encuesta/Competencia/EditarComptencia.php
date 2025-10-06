<?php

namespace App\Livewire\Encuesta\Competencia;

use App\Models\Categoria;
use App\Models\CategoriaCompetencia;
use App\Models\Competencia;
use App\Models\Nivel;
use App\Models\NivelCompetencia;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class EditarComptencia extends Component
{

     // Propiedad para almacenar la competencia que estamos editando
    public Competencia $competencia;

    // Propiedades para los campos del formulario (igual que en Crear)
    public string $nombre_competencia = '';
    public string $definicion_competencia = '';
    public ?int $categoria_id_competencia = null;
    public array $niveles = [];

    // Propiedad para la lista de categorías
    public $categorias = [];

    // El método mount recibe la competencia gracias al Route Model Binding de Laravel
    public function mount(Competencia $competencia): void
    {
        $this->competencia = $competencia;
        $this->categorias = Categoria::orderBy('categoria')->get();

        // Cargar los datos existentes en el formulario
        $this->nombre_competencia = $competencia->nombre_competencia;
        $this->definicion_competencia = $competencia->definicion_competencia;
        $this->categoria_id_competencia = $competencia->categoria_id_competencia;

        // Cargar los niveles existentes. Usamos toArray() para convertir la colección a un array simple
        $this->niveles = $competencia->niveles->toArray();
    }

    // Los métodos para añadir/eliminar niveles son idénticos a los de CrearCompetencia
    public function añadirNivel(): void
    {
        $this->niveles[] = ['nombre_nivel' => '', 'descripcion_nivel' => ''];
    }

    public function eliminarNivel(int $index): void
    {
        // Si el nivel tiene un 'id', significa que existe en la BD y debemos eliminarlo
        if (isset($this->niveles[$index]['id_nivel'])) {
            Nivel::find($this->niveles[$index]['id_nivel'])->delete();
        }
        unset($this->niveles[$index]);
        $this->niveles = array_values($this->niveles);
    }

    // Las reglas de validación también son idénticas
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

    public function update(): void
    {
        $this->validate();

        DB::transaction(function () {
            // 1. Actualizar la competencia principal
            $this->competencia->update([
                'nombre_competencia' => $this->nombre_competencia,
                'definicion_competencia' => $this->definicion_competencia,
                'categoria_id_competencia' => $this->categoria_id_competencia,
            ]);

            // 2. Sincronizar los niveles (actualizar existentes, crear nuevos)
            foreach ($this->niveles as $nivelData) {
                $this->competencia->niveles()->updateOrCreate(
                    ['id_nivel' => $nivelData['id_nivel'] ?? null], // Condición de búsqueda
                    [                                             // Datos para actualizar o crear
                        'nombre_nivel' => $nivelData['nombre_nivel'],
                        'descripcion_nivel' => $nivelData['descripcion_nivel'],
                    ]
                );
            }
        });

        session()->flash('message', '¡Competencia actualizada exitosamente!');
        // Redirigimos a la página de revisar para ver los cambios
        $this->redirect(route('revisar-competencia'), navigate: true);
    }


    public function render()
    {
        return view('livewire.encuesta.competencia.editar-comptencia')->layout('layouts.app');
    }
}
