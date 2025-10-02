<?php

use App\Livewire\Encuesta\CrearEmpresa;
use App\Livewire\Encuesta\Departamento\CrearDepartamento;
use App\Livewire\Encuesta\Departamento\EditarDepartamento;
use App\Livewire\Encuesta\Departamento\ManualUsuarioDepModal;
use App\Livewire\Encuesta\Departamento\MostrarDepartamento;
use App\Livewire\Encuesta\Departamento\VerDepartamento;
use App\Livewire\Encuesta\EditarEmpresa;
use App\Livewire\Encuesta\MostrarEmpresa;
use App\Livewire\Encuesta\Usuario\CrearUsuario;
use App\Livewire\Encuesta\Usuario\EditarUsuario;
use App\Livewire\Encuesta\Usuario\MostrarUsuario;
use App\Livewire\Encuesta\Usuario\VerUsuario;
use App\Livewire\Encuesta\VerEmpresa;
use App\Livewire\MenuNavegacion;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/menu-navegacion', MenuNavegacion::class)->name('menu-navegacion');
Route::get('/crear-empresa', CrearEmpresa::class)->name('crear-empresa');
Route::get('/mostrar-empresa', MostrarEmpresa::class)->name('mostrar-empresa');
Route::get('/empresas/{empresa}', VerEmpresa::class)->name('ver-empresa');
Route::get('/empresas/editar/{empresa}', EditarEmpresa::class)->name('editar-empresa');
Route::get('/departamentos/crear', CrearDepartamento::class)->name('crear-departamento');
Route::get('/departamento', MostrarDepartamento::class)->name('mostrar-departamento');
Route::get('/departamentos/{departamento}', VerDepartamento::class)->name('ver-departamento');
Route::get('/departamentos/{departamento}/editar', EditarDepartamento::class)->name('editar-departamento');
Route::get('/manual-usuario-dep-modal', ManualUsuarioDepModal::class)->name('manual-usuario-dep-modal');
Route::get('/usuarios/crear', CrearUsuario::class)->name('crear-usuario');
Route::get('/usuarios', MostrarUsuario::class)->name('mostrar-usuario');
Route::get('/usuarios/{user}', VerUsuario::class)->name('ver-usuario');
Route::get('/usuarios/{user}/editar', EditarUsuario::class)->name('editar-usuario');
