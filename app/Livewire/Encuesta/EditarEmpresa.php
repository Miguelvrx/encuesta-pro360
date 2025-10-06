<?php

namespace App\Livewire\Encuesta;

use App\Models\Empresa;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EditarEmpresa extends Component
{

    use WithFileUploads; // Necesitamos esto para manejar la subida de archivos

    // Propiedad para la empresa que estamos editando
    public Empresa $empresa;

    // --- PROPIEDADES DEL FORMULARIO (las mismas que en CrearEmpresa) ---
    public $nombre_comercial = '';
    public $razon_social = '';
    public $sector = '';
    public $estado_inicial = '';
    public $numero_empleados = '';
    public $fecha_registro = '';
    public $ano_mercado = '';
    public $tipo_organizacion = '';
    public $rfc = '';
    public $direccion = '';
    public $codigo_postal = '';
    #[Validate('nullable|image|mimes:png,jpg,jpeg|max:5120')]
    public $logo; // Para el nuevo logo
    public $logoExistente; // Para mostrar/borrar el logo antiguo
    public $contacto_nombre = '';
    public $contacto_puesto = '';
    public $contacto_telefono = '';
    public $contacto_correo = '';

    // --- PROPIEDADES PARA LOS SELECTORES DEPENDIENTES ---
    public array $paises = [];
    public array $estados = [];
    public array $ciudades = [];
    public array $municipios = [];

    public $paisSeleccionado = null;
    public $estadoSeleccionado = null;
    public $ciudadSeleccionada = null;
    public $municipioSeleccionado = null;

    // Mapeo para mensajes de validación
    protected $validationAttributes = [
        'paisSeleccionado' => 'país',
        'estadoSeleccionado' => 'estado',
        'ciudadSeleccionada' => 'ciudad',
        'municipioSeleccionado' => 'municipio',
    ];

    /**
     * El método mount ahora es compatible y tiene su propia lógica.
     */
    public function mount(Empresa $empresa): void
    {
        $this->empresa = $empresa;
        $this->logoExistente = $empresa->logo;

        // 1. Llenamos los campos del formulario desde el modelo
        $this->fill($empresa);
        $this->fecha_registro = $empresa->fecha_registro->format('Y-m-d');

        // 2. Cargamos las listas para los selectores en cascada
        $this->paises = $this->obtenerPaises();
        $this->paisSeleccionado = $empresa->pais;

        $this->estados = $this->obtenerEstados($this->paisSeleccionado);
        $this->estadoSeleccionado = $empresa->estado;

        $listaCiudades = $this->obtenerCiudadesMunicipios($this->paisSeleccionado, $this->estadoSeleccionado);
        $this->ciudades = $listaCiudades;
        $this->municipios = $listaCiudades;

        $this->ciudadSeleccionada = $empresa->ciudad;
        $this->municipioSeleccionado = $empresa->municipio;
    }

    // --- Hooks para actualizar los selectores (copiados de CrearEmpresa) ---
    public function updatedPaisSeleccionado($pais): void
    {
        $this->estados = !is_null($pais) ? $this->obtenerEstados($pais) : [];
        $this->reset('estadoSeleccionado', 'ciudadSeleccionada', 'municipioSeleccionado');
        $this->ciudades = [];
        $this->municipios = [];
    }

    public function updatedEstadoSeleccionado($estado): void
    {
        $lista = !is_null($estado) ? $this->obtenerCiudadesMunicipios($this->paisSeleccionado, $estado) : [];
        $this->ciudades = $lista;
        $this->municipios = $lista;
        $this->reset('ciudadSeleccionada', 'municipioSeleccionado');
    }

    // --- Reglas de validación (copiadas de CrearEmpresa y ajustadas) ---
    protected function rules()
    {
        return [
            'nombre_comercial' => 'required|string|max:255',
            'razon_social' => 'required|string|max:255',
            'sector' => 'required|string|max:100',
            'estado_inicial' => 'required|string|max:100',
            'numero_empleados' => 'required|string|in:1-10,11-50,51-100,101-500,500+',
            'fecha_registro' => 'required|date',
            'ano_mercado' => 'required|integer|min:1900|max:' . date('Y'),
            'tipo_organizacion' => 'required|string|max:100',
            'rfc' => 'required|string|max:20|unique:empresas,rfc,' . $this->empresa->id_empresa . ',id_empresa',
            'direccion' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:10',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:5120',
            'contacto_nombre' => 'nullable|string|max:255',
            'contacto_puesto' => 'nullable|string|max:100',
            'contacto_telefono' => 'nullable|string|max:20',
            'contacto_correo' => 'nullable|email|max:255',
            'paisSeleccionado' => 'required|string|max:100',
            'estadoSeleccionado' => 'required|string|max:100',
            'ciudadSeleccionada' => 'required|string|max:100',
            'municipioSeleccionado' => 'required|string|max:100',
        ];
    }

    public function update()
    {
        $validatedData = $this->validate($this->rules());

        $validatedData['pais'] = $this->paisSeleccionado;
        $validatedData['estado'] = $this->estadoSeleccionado;
        $validatedData['ciudad'] = $this->ciudadSeleccionada;
        $validatedData['municipio'] = $this->municipioSeleccionado;

        if ($this->logo) {
            $validatedData['logo'] = $this->logo->store('logos', 'public');
            if ($this->logoExistente) {
                Storage::disk('public')->delete($this->logoExistente);
            }
        }


        $this->empresa->update($validatedData);
        session()->flash('message', '¡Empresa actualizada exitosamente!');
        $this->redirect(route('mostrar-empresa'), navigate: true);
    }

    // --- Métodos API (copiados de CrearEmpresa) ---
    private function obtenerPaises(): array
    {
        $response = Http::get('https://countriesnow.space/api/v0.1/countries/positions');
        return $response->successful() ? collect($response->json()['data'])->sortBy('name')->all() : [];
    }
    private function obtenerEstados($pais): array
    {
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/states', ['country' => $pais]);
        return ($response->successful() && isset($response->json()['data']['states'])) ? $response->json()['data']['states'] : [];
    }
    private function obtenerCiudadesMunicipios($pais, $estado): array
    {
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', ['country' => $pais, 'state' => $estado]);
        return ($response->successful() && !empty($response->json()['data'])) ? collect($response->json()['data'])->sort()->all() : [];
    }


    // --- FIN DE LA SOLUCIÓN ---
    public function render()
    {
        return view('livewire.encuesta.editar-empresa')->layout('layouts.app');
    }
}
