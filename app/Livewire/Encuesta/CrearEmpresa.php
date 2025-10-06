<?php

namespace App\Livewire\Encuesta;

use App\Models\Empresa;
use Illuminate\Support\Facades\Http;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearEmpresa extends Component
{
    // use WithFileUploads;
    use WithFileUploads;


    // --- PROPIEDADES DEL MODELO EMPRESA ---
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
    // #[On('upload:finished')]
    // public $logo;
    #[Validate('nullable|image|mimes:png,jpg,jpeg|max:5120')]
    public $image;
    public $contacto_nombre = '';
    public $contacto_puesto = '';
    public $contacto_telefono = '';
    public $contacto_correo = '';

    // --- PROPIEDADES PARA LOS SELECTORES DEPENDIENTES ---

    // 2. Propiedades para almacenar los listados que vienen de la API
    public array $paises = [];
    public array $estados = [];
    public array $ciudades = []; // NUEVO: Para el selector de Ciudad
    public array $municipios = []; // Ya lo tenías, lo usaremos para el selector de Municipio

    // 3. Renombramos las propiedades que guardan la selección para evitar conflictos.
    //    Usaremos 'paisSeleccionado', 'estadoSeleccionado', 'ciudadSeleccionada'.
    //    Las propiedades originales 'pais', 'estado', 'ciudad' se llenarán antes de guardar.
    public $paisSeleccionado = null;
    public $estadoSeleccionado = null;
    public $ciudadSeleccionada = null; // NUEVO: Para la selección de Ciudad
    public $municipioSeleccionado = null; // NUEVO: Para la selección de Municipio

    // 4. Mapeamos las propiedades del selector a las del modelo para la validación.
    //    Esto es clave para que las reglas de validación funcionen correctamente.
    protected $validationAttributes = [
        'paisSeleccionado' => 'país',
        'estadoSeleccionado' => 'estado',
        'ciudadSeleccionada' => 'ciudad',
        'municipioSeleccionado' => 'municipio', // NUEVO
    ];

    // 5. El método mount se ejecuta al iniciar el componente.
    // En CrearEmpresa.php
    public function mount(): void
    {
        $this->paises = $this->obtenerPaises();
    }


    // 6. Hook que se dispara cuando el usuario selecciona un país.
    public function updatedPaisSeleccionado($pais): void
    {
       $this->estados = !is_null($pais) ? $this->obtenerEstados($pais) : [];
        // Reseteamos todos los niveles inferiores
        $this->reset('estadoSeleccionado', 'ciudadSeleccionada', 'municipioSeleccionado');
        $this->ciudades = [];
        $this->municipios = [];
    }

    // 7. Hook que se dispara cuando el usuario selecciona un estado.
    public function updatedEstadoSeleccionado($estado): void
    {
      // La API nos da una lista de "ciudades" que usaremos para ambos selectores
        $listaCiudadesMunicipios = !is_null($estado) ? $this->obtenerCiudadesMunicipios($this->paisSeleccionado, $estado) : [];
        
        $this->ciudades = $listaCiudadesMunicipios;
        $this->municipios = $listaCiudadesMunicipios; // Usamos la misma lista

        // Reseteamos los niveles inferiores
        $this->reset('ciudadSeleccionada', 'municipioSeleccionado');
    }

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
            'rfc' => 'required|string|max:20|unique:empresas,rfc',
            'direccion' => 'required|string|max:255',
            'codigo_postal' => 'required|string|max:10',
            'image' => 'nullable|image|max:5120',
            'contacto_nombre' => 'nullable|string|max:255',
            'contacto_puesto' => 'nullable|string|max:100',
            'contacto_telefono' => 'nullable|string|max:20',
            'contacto_correo' => 'nullable|email|max:255',

            // 8. Actualizamos las reglas para validar las nuevas propiedades.
            'paisSeleccionado' => 'required|string|max:100',
            'estadoSeleccionado' => 'required|string|max:100',
            'ciudadSeleccionada' => 'required|string|max:100',
            'municipioSeleccionado' => 'required|string|max:100', // NUEVO  
        ];
    }

    // En app/Livewire/Encuesta/CrearEmpresa.php

    public function save()
    {
        // 1. Validamos los datos del formulario usando las reglas definidas.
        $validatedData = $this->validate($this->rules());

        // 2. Añadimos los datos de los selectores dependientes al array validado.
        $validatedData['pais'] = $this->paisSeleccionado;
        $validatedData['estado'] = $this->estadoSeleccionado;
        $validatedData['ciudad'] = $this->ciudadSeleccionada;
        $validatedData['municipio'] = $this->municipioSeleccionado; // NUEVO

        // 3. Manejamos la subida de la imagen (logo).
        //    Cambiamos 'image' por 'logo' para que coincida con el nombre de la columna en la BD.
        if ($this->image) {
            // La columna en tu BD se llama 'logo', no 'image'.
            $validatedData['logo'] = $this->image->store('logos', 'public');
        }

        // 4. Intentamos crear el registro en la base de datos.
        try {
            Empresa::create($validatedData);

            // Usamos session()->flash() para el mensaje de éxito.
            session()->flash('message', '¡Empresa creada exitosamente!');

            // Redirigimos al listado de empresas.
            $this->redirect(route('mostrar-empresa'), navigate: true);
        } catch (\Exception $e) {
            // Si algo falla, guardamos el error en la sesión y permanecemos en la página.
            session()->flash('error', 'Error al crear la empresa: ' . $e->getMessage());
        }
    }


    // --- 10. MÉTODOS PARA OBTENER DATOS DE LA API ---

    private function obtenerPaises(): array
    {
        $response = Http::get('https://countriesnow.space/api/v0.1/countries/positions');
        if ($response->successful()) {
            return collect($response->json()['data'])->sortBy('name')->all();
        }
        return [];
    }

    private function obtenerEstados($pais): array
    {
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/states', ['country' => $pais]);
        if ($response->successful() && isset($response->json()['data']['states'])) {
            return $response->json()['data']['states'];
        }
        return [];
    }

    private function obtenerMunicipios($pais, $estado): array
    {
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', ['country' => $pais, 'state' => $estado]);
        if ($response->successful() && !empty($response->json()['data'])) {
            return collect($response->json()['data'])->sort()->all();
        }
        return [];
    }

    private function obtenerCiudadesMunicipios($pais, $estado): array
    {
        $response = Http::post('https://countriesnow.space/api/v0.1/countries/state/cities', ['country' => $pais, 'state' => $estado] );
        if ($response->successful() && !empty($response->json()['data'])) {
            return collect($response->json()['data'])->sort()->all();
        }
        return [];
    }

    public function render()
    {
        return view('livewire.encuesta.crear-empresa')->layout('layouts.app');
    }
}
