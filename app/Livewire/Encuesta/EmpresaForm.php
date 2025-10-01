<?php

namespace App\Livewire\Encuesta;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class EmpresaForm extends Component
{

    // Propiedades para almacenar los datos de los selectores
    public $paises = [];
    public $estados = [];
    public $municipios = [];

    // Propiedades para almacenar la selección del usuario
    // El #[Modelable] sincroniza esta propiedad con el componente padre si es necesario.
    #[\Livewire\Attributes\Modelable]
    public $paisSeleccionado = null;

    #[\Livewire\Attributes\Modelable]
    public $estadoSeleccionado = null;

    #[\Livewire\Attributes\Modelable]
    public $municipioSeleccionado = null;

    /**
     * El método mount() se ejecuta cuando el componente se inicializa.
     * Aquí cargamos la lista inicial de países.
     */
    public function mount(): void
    {
        // Usaremos una API pública para obtener los datos.
        // Lo ideal sería tener estos datos en tu propia base de datos.
        $this->paises = $this->obtenerPaises();
        $this->estados = [];
        $this->municipios = [];
    }

    /**
     * Este método se ejecuta automáticamente cuando la propiedad $paisSeleccionado cambia.
     * Es un "gancho" (hook) de actualización de Livewire.
     */
    public function updatedPaisSeleccionado($pais): void
    {
        if (!is_null($pais)) {
            // Cuando se selecciona un país, cargamos sus estados/provincias
            $this->estados = $this->obtenerEstados($pais);
        }
        // Reseteamos las selecciones de estado y municipio
        $this->estadoSeleccionado = null;
        $this->municipioSeleccionado = null;
        $this->municipios = [];
    }

    /**
     * Este método se ejecuta automáticamente cuando la propiedad $estadoSeleccionado cambia.
     */
    public function updatedEstadoSeleccionado($estado): void
    {
        if (!is_null($estado)) {
            // Cuando se selecciona un estado, cargamos sus municipios
            $this->municipios = $this->obtenerMunicipios($this->paisSeleccionado, $estado);
        }
        // Reseteamos la selección del municipio
        $this->municipioSeleccionado = null;
    }

    /**
     * Renderiza la vista del componente.
     */
    // public function render()
    // {
    //     return view('livewire.empresa-form');
    // }

    // --- MÉTODOS PARA OBTENER DATOS (usando una API externa) ---

    private function obtenerPaises(): array
    {
        // API para obtener países
        $response = Http::get('https://countriesnow.space/api/v0.1/countries/positions' );
        if ($response->successful()) {
            // Ordenamos los países alfabéticamente
            return collect($response->json()['data'])->sortBy('name')->all();
        }
        return [];
    }

    private function obtenerEstados($pais): array
    {
        // API para obtener estados de un país
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/states', [
            'country' => $pais
        ] );
        if ($response->successful() && isset($response->json()['data']['states'])) {
            return $response->json()['data']['states'];
        }
        return [];
    }

    private function obtenerMunicipios($pais, $estado): array
    {
        // API para obtener ciudades/municipios de un estado
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', [
            'country' => $pais,
            'state' => $estado
        ] );
        if ($response->successful() && !empty($response->json()['data'])) {
            // La API devuelve una lista simple, la ordenamos
            return collect($response->json()['data'])->sort()->all();
        }
        return [];
    }


    public function render()
    {
        return view('livewire.encuesta.empresa-form');
    }
}
