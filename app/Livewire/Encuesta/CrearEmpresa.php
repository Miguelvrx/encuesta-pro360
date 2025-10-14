<?php

namespace App\Livewire\Encuesta;

use App\Models\Empresa;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;

class CrearEmpresa extends Component
{
    use WithFileUploads;

    // --- PROPIEDADES DEL FORMULARIO ---
    public $nombre_comercial = "";
    public $razon_social = "";
    public $sector = "";
    public $estado_inicial = "";
    public $numero_empleados = "";
    public $fecha_registro = "";
    public $ano_mercado = "";
    public $tipo_organizacion = "";
    public $rfc = "";
    public $direccion = "";
    public $codigo_postal = "";
    public $contacto_nombre = "";
    public $contacto_puesto = "";
    public $contacto_telefono = "";
    public $contacto_correo = "";

    // --- PROPIEDADES DEL LOGO ---
    #[Validate("nullable|image|mimes:png,jpg,jpeg|max:5120|dimensions:min_width=100,min_height=100")]
    public $logo; // Para el logo que se sube

    // --- PROPIEDADES DE UBICACIÓN ---
    public $pais = "";
    public $estado = "";
    public $ciudad = "";
    public $municipio = "";
    public $countries = [];
    public $states = [];
    public $cities = [];

    public function mount(): void
    {
        // Inicializar la lista de países
        $this->getCountries();

        \Illuminate\Support\Facades\Log::info('Componente CrearEmpresa montado. Propiedad logo definida: ' . (isset($this->logo) ? 'Sí' : 'No'));
    }

    protected function rules()
    {
        return [
            "nombre_comercial" => "required|string|max:255",
            "razon_social" => "required|string|max:255",
            "sector" => "required|string|max:100",
            "estado_inicial" => "required|string|max:100",
            "numero_empleados" => "required|string|in:1-10,11-50,51-100,101-500,500+",
            "fecha_registro" => "required|date",
            "ano_mercado" => "required|integer|min:1900|max:" . date("Y"),
            "tipo_organizacion" => "required|string|max:100",
            "rfc" => "required|string|max:20|unique:empresas,rfc",
            "direccion" => "required|string|max:255",
            "codigo_postal" => "required|string|max:10",
            "logo" => "nullable|image|mimes:png,jpg,jpeg|max:5120|dimensions:min_width=100,min_height=100",
            "contacto_nombre" => "nullable|string|max:255",
            "contacto_puesto" => "nullable|string|max:100",
            "contacto_telefono" => "nullable|string|max:20",
            "contacto_correo" => "nullable|email|max:255",
            "pais" => "required|string|max:100",
            "estado" => "required|string|max:100",
            "ciudad" => "required|string|max:100",
            "municipio" => "required|string|max:100",
        ];
    }

    protected $messages = [
        "logo.image" => "El archivo debe ser una imagen válida.",
        "logo.mimes" => "El logo debe estar en formato PNG, JPG o JPEG.",
        "logo.max" => "El logo no debe exceder los 5 MB.",
        "logo.dimensions" => "El logo debe tener al menos 100x100 píxeles.",
    ];

    public function updatedLogo()
    {
        \Illuminate\Support\Facades\Log::info('Propiedad logo actualizada. Tipo: ' . (is_object($this->logo) ? get_class($this->logo) : 'No es objeto'));
    }

    public function getCountries()
    {
        try {
            $response = Http::get("https://countriesnow.space/api/v0.1/countries/positions");
            if ($response->successful()) {
                $this->countries = collect($response->json()["data"])->pluck("name")->sort()->toArray();
                \Illuminate\Support\Facades\Log::info('Países cargados exitosamente: ' . count($this->countries));
            } else {
                $this->countries = [];
                \Illuminate\Support\Facades\Log::error('Error al cargar países. Código: ' . $response->status() . ', Respuesta: ' . $response->body());
                // Usa dispatch en lugar de session()->flash()
                $this->dispatch('toastr-error', message: "No se pudieron cargar los países. Código: " . $response->status());
            }
        } catch (\Exception $e) {
            $this->countries = [];
            \Illuminate\Support\Facades\Log::error('Excepción al cargar países: ' . $e->getMessage());
            // Usa dispatch en lugar de session()->flash()
            $this->dispatch('toastr-error', message: "No se pudieron cargar los países: " . $e->getMessage());
        }
    }

    public function updatedPais($value)
    {
        $this->estado = "";
        $this->ciudad = "";
        $this->states = [];
        $this->cities = [];
        if ($value) {
            $this->getStates();
        }
    }

    public function getStates()
    {
        if (empty($this->pais)) return;
        try {
            $response = Http::post("https://countriesnow.space/api/v0.1/countries/states", [
                "country" => $this->pais
            ]);
            if ($response->successful()) {
                $this->states = collect($response->json()["data"]["states"])->pluck("name")->sort()->toArray();
                \Illuminate\Support\Facades\Log::info('Estados cargados para ' . $this->pais . ': ' . count($this->states));
            } else {
                $this->states = [];
                \Illuminate\Support\Facades\Log::error('Error al cargar estados para ' . $this->pais . '. Código: ' . $response->status() . ', Respuesta: ' . $response->body());
                session()->flash("error", "No se pudieron cargar los estados para " . $this->pais . ".");
            }
        } catch (\Exception $e) {
            $this->states = [];
            \Illuminate\Support\Facades\Log::error('Excepción al cargar estados: ' . $e->getMessage());
            session()->flash("error", "No se pudieron cargar los estados: " . $e->getMessage());
        }
    }

    public function updatedEstado($value)
    {
        $this->ciudad = "";
        $this->cities = [];
        if ($value) {
            $this->getCities();
        }
    }

    public function getCities()
    {
        if (empty($this->pais) || empty($this->estado)) return;
        try {
            $response = Http::post("https://countriesnow.space/api/v0.1/countries/state/cities", [
                "country" => $this->pais,
                "state" => $this->estado
            ]);
            if ($response->successful()) {
                $this->cities = collect($response->json()["data"])->sort()->toArray();
                \Illuminate\Support\Facades\Log::info('Ciudades cargadas para ' . $this->estado . ': ' . count($this->cities));
            } else {
                $this->cities = [];
                \Illuminate\Support\Facades\Log::error('Error al cargar ciudades para ' . $this->estado . '. Código: ' . $response->status() . ', Respuesta: ' . $response->body());
                session()->flash("error", "No se pudieron cargar las ciudades para " . $this->estado . ".");
            }
        } catch (\Exception $e) {
            $this->cities = [];
            \Illuminate\Support\Facades\Log::error('Excepción al cargar ciudades: ' . $e->getMessage());
            session()->flash("error", "No se pudieron cargar las ciudades: " . $e->getMessage());
        }
    }

    // public function save()
    // {
    //     $validatedData = $this->validate();

    //     try {
    //         if ($this->logo) {
    //             \Illuminate\Support\Facades\Log::info('Intentando almacenar imagen en storage/app/public/logos');
    //             \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('logos');
    //             $validatedData["logo"] = $this->logo->store('logos', 'public');
    //             \Illuminate\Support\Facades\Log::info('Imagen almacenada en: ' . $validatedData["logo"]);
    //         } else {
    //             $validatedData["logo"] = null;
    //         }

    //         Empresa::create($validatedData);
    //         session()->flash("message", "¡Empresa creada exitosamente!");
    //         $this->redirect(route("mostrar-empresa"), navigate: true);
    //     } catch (\Exception $e) {
    //         \Illuminate\Support\Facades\Log::error("Error al crear empresa: " . $e->getMessage());
    //         session()->flash("error", "Error al crear la empresa: " . $e->getMessage());
    //     }
    // }
    

    public function save()
    {
        $validatedData = $this->validate();

        try {
            if ($this->logo) {
                \Illuminate\Support\Facades\Log::info('Intentando almacenar imagen en storage/app/public/logos');
                \Illuminate\Support\Facades\Storage::disk('public')->makeDirectory('logos');
                $validatedData["logo"] = $this->logo->store('logos', 'public');
                \Illuminate\Support\Facades\Log::info('Imagen almacenada en: ' . $validatedData["logo"]);
            } else {
                $validatedData["logo"] = null;
            }

            Empresa::create($validatedData);

            // En lugar de session()->flash(), usa dispatch para Toastr
            $this->dispatch('toastr-success', message: '¡Empresa creada exitosamente!');

            $this->redirect(route("mostrar-empresa"), navigate: true);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error("Error al crear empresa: " . $e->getMessage());

            // En lugar de session()->flash(), usa dispatch para Toastr
            $this->dispatch('toastr-error', message: 'Error al crear la empresa: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.encuesta.crear-empresa')->layout('layouts.app');
    }
}
