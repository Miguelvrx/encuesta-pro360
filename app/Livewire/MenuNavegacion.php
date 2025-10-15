<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Livewire\Attributes\On;
use Livewire\Component;

class MenuNavegacion extends Component
{
    public $isSidebarOpen = false;
    public $activeMenu = null; // 'usuarios', 'encuestas', o null
    public $manuallyClosedMenus = []; // Array para trackear menús cerrados manualmente
    public $previousMenuForRoute = null; // Nueva propiedad para rastrear la sección previa

    // Mapeo de rutas a menús padres
    private $routeMenuMap = [
        'dashboard' => null,
        'crear-empresa' => 'usuarios',
        'mostrar-empresa' => 'usuarios',
        'crear-departamento' => 'departamentos',
        'mostrar-departamento' => 'departamentos',
        'crear-usuario' => 'users',
        'mostrar-usuario' => 'users',
        'crear-competencia' => 'competencias',
        'revisar-competencia' => 'competencias',
        'catalogo-competencia' => 'competencias',
        'gestionar-pregunta' => 'preguntas',
        'crear-evaluacion' => 'evaluaciones',


        // 'index' => 'usuarios',
        // 'evaluacion' => 'usuarios',
        // 'mis-resultados' => 'usuarios',
        // 'resultado-jefe' => 'usuarios',
        // Agrega más rutas según necesites
    ];

    public function mount()
    {
        $this->isSidebarOpen = $this->isDesktop() ? true : session()->get('isSidebarOpen', false);
        $this->manuallyClosedMenus = session()->get('manuallyClosedMenus', []);
        $this->previousMenuForRoute = session()->get('previousMenuForRoute', null);

        // Determinar el menú activo basado en la ruta actual
        $this->setActiveMenuFromRoute();
    }

    #[On('urlChanged')]
    public function onUrlChanged()
    {
        // Cuando cambia la URL, determinar qué menú debería estar abierto
        $this->setActiveMenuFromRoute();
    }

    private function getMenuForRoute($routeName)
    {
        if (isset($this->routeMenuMap[$routeName])) {
            return $this->routeMenuMap[$routeName];
        }

        if (
            str_contains($routeName, 'usuarios') ||
            str_contains($routeName, 'empresa') ||
            str_contains($routeName, 'evaluacion') ||
            str_contains($routeName, 'resultados')
        ) {
            return 'usuarios';
        } elseif (str_contains($routeName, 'encuestas')) {
            return 'encuestas';
        }

        return null;
    }

    private function setActiveMenuFromRoute()
    {
        $currentRouteName = Route::currentRouteName();
        $menuForRoute = $this->getMenuForRoute($currentRouteName);

        // Detectar si cambiamos de sección (ej. de 'dashboard' a 'usuarios' o de 'encuestas' a 'usuarios')
        if ($menuForRoute && $menuForRoute !== $this->previousMenuForRoute) {
            // Limpiar el cierre manual para este menú al entrar desde otra sección
            $this->manuallyClosedMenus = array_diff($this->manuallyClosedMenus, [$menuForRoute]);
        }

        // Establecer el menú activo si NO está cerrado manualmente
        if ($menuForRoute && !in_array($menuForRoute, $this->manuallyClosedMenus)) {
            $this->activeMenu = $menuForRoute;
        } else {
            $this->activeMenu = null;
        }

        // Actualizar el menú previo para la próxima llamada
        $this->previousMenuForRoute = $menuForRoute;

        session()->put('activeMenu', $this->activeMenu);
        session()->put('manuallyClosedMenus', $this->manuallyClosedMenus);
        session()->put('previousMenuForRoute', $this->previousMenuForRoute);
    }

    public function toggleSidebar()
    {
        $this->isSidebarOpen = !$this->isSidebarOpen;
        session()->put('isSidebarOpen', $this->isSidebarOpen);
        Log::info('Sidebar toggled: ' . ($this->isSidebarOpen ? 'Open' : 'Closed'));
    }

    public function toggleMenu($menu)
    {
        if ($this->activeMenu === $menu) {
            // El usuario está cerrando manualmente el menú
            $this->activeMenu = null;
            if (!in_array($menu, $this->manuallyClosedMenus)) {
                $this->manuallyClosedMenus[] = $menu;
            }
        } else {
            // El usuario está abriendo un menú
            $this->activeMenu = $menu;
            $this->manuallyClosedMenus = array_diff($this->manuallyClosedMenus, [$menu]);
        }

        session()->put('activeMenu', $this->activeMenu);
        session()->put('manuallyClosedMenus', $this->manuallyClosedMenus);
    }

    public function isMenuOpen($menu)
    {
        return $this->activeMenu === $menu;
    }

    public function isActiveRoute($routeName)
    {
        return Route::currentRouteName() === $routeName;
    }

    public function isActiveRouteGroup($routes = [])
    {
        $currentRoute = Route::currentRouteName();
        return in_array($currentRoute, $routes);
    }

    public function closeMenus()
    {
        if (!$this->isDesktop()) {
            $this->isSidebarOpen = false;
            session()->put('isSidebarOpen', false);
        }
    }

    public function resetManualClosures()
    {
        $this->manuallyClosedMenus = [];
        session()->put('manuallyClosedMenus', []);
        $this->setActiveMenuFromRoute();
    }

    private function isDesktop()
    {
        return request()->header('sec-ch-width') >= 768 || request()->is('localhost');
    }

    public function render()
    {
        return view('livewire.menu-navegacion');
    }
}
