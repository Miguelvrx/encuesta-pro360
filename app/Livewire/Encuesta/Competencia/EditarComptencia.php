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

    // Propiedades para los campos del formulario
    public string $nombre_competencia = '';
    public string $definicion_competencia = '';
    public ?int $categoria_id_competencia = null;
    public array $niveles = [];

    public $categorias = [];

    // --- INICIO DE LA SOLUCIÓN ---

    // 1. Definimos la escala de niveles, igual que en CrearCompetencia
    public array $escalaDeNiveles = [
        5 => ['nombre' => 'Excepcional', 'tagline' => 'Modelo a seguir con impacto sostenido'],
        4 => ['nombre' => 'Supera las Expectativas', 'tagline' => 'Desempeño consistentemente superior'],
        3 => ['nombre' => 'Competente', 'tagline' => 'Cumple de forma confiable lo esperado'],
        2 => ['nombre' => 'En Desarrollo', 'tagline' => 'Avanza con áreas por fortalecer'],
        1 => ['nombre' => 'Requiere Apoyo', 'tagline' => 'Necesita acompañamiento para el estándar'],
    ];

    public function mount(Competencia $competencia): void
    {
        $this->competencia = $competencia;
        $this->categorias = Categoria::orderBy('categoria')->get(); // Corregido

        // Cargar los datos de la competencia principal
        $this->nombre_competencia = $competencia->nombre_competencia;
        $this->definicion_competencia = $competencia->definicion_competencia;
        $this->categoria_id_competencia = $competencia->categoria_id_competencia;

        // 2. Cargar los niveles existentes y mapearlos a nuestra estructura
        $nivelesExistentes = $competencia->niveles()->orderBy('id_nivel', 'desc')->get();

        foreach (array_reverse($this->escalaDeNiveles, true) as $numero => $data) {
            // Buscamos el nivel existente que coincida con el nombre estándar
            $nivelGuardado = $nivelesExistentes->firstWhere('nombre_nivel', $data['nombre']);

            $this->niveles[] = [
                'id_nivel' => $nivelGuardado->id_nivel ?? null, // Guardamos el ID para la actualización
                'numero' => $numero,
                'nombre_nivel' => $data['nombre'],
                'tagline' => $data['tagline'],
                'descripcion_nivel' => $nivelGuardado->descripcion_nivel ?? '' // Usamos la descripción guardada
            ];
        }
    }

    // 3. Ya no se necesitan los métodos añadirNivel() ni eliminarNivel()

    protected function rules(): array
    {
        return [
            'nombre_competencia' => 'required|string|max:255',
            'definicion_competencia' => 'required|string',
            'categoria_id_competencia' => 'required|integer|exists:categoria_competencias,id_categoria_competencia',
            'niveles.*.descripcion_nivel' => 'required|string',
        ];
    }

    protected $validationAttributes = [
        'nombre_competencia' => 'nombre de la competencia',
        'definicion_competencia' => 'definición de la competencia',
        'categoria_id_competencia' => 'categoría',
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

            // 2. Sincronizar los 5 niveles fijos
            foreach ($this->niveles as $nivelData) {
                // Usamos updateOrCreate para manejar el caso (improbable) de que un nivel no exista.
                // La condición de búsqueda es el ID del nivel.
                $this->competencia->niveles()->updateOrCreate(
                    ['id_nivel' => $nivelData['id_nivel']],
                    [
                        'nombre_nivel' => $nivelData['nombre_nivel'],
                        'descripcion_nivel' => $nivelData['descripcion_nivel'],
                    ]
                );
            }
        });

        session()->flash('message', '¡Competencia actualizada exitosamente!');
        $this->redirect(route('revisar-competencia'), navigate: true);
    }
    // --- FIN DE LA SOLUCIÓN ---

    public function render()
    {
        return view('livewire.encuesta.competencia.editar-comptencia')->layout('layouts.app');
    }
}
