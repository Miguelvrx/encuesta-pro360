<?php

use App\Livewire\Encuesta\CrearEmpresa;
use App\Livewire\Encuesta\EditarEmpresa;
use App\Livewire\Encuesta\MostrarEmpresa;
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