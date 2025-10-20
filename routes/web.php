<?php

use App\Livewire\Encuesta\Competencia\CatalogoCompetencia;
use App\Livewire\Encuesta\Competencia\CrearCompetencia;
use App\Livewire\Encuesta\Competencia\EditarComptencia;
use App\Livewire\Encuesta\Competencia\RevisarComptencia;
use App\Livewire\Encuesta\CrearEmpresa;
use App\Livewire\Encuesta\Departamento\CrearDepartamento;
use App\Livewire\Encuesta\Departamento\EditarDepartamento;
use App\Livewire\Encuesta\Departamento\ManualUsuarioDepModal;
use App\Livewire\Encuesta\Departamento\MostrarDepartamento;
use App\Livewire\Encuesta\Departamento\VerDepartamento;
use App\Livewire\Encuesta\EditarEmpresa;
use App\Livewire\Encuesta\Evaluacion\CrearEvaluacion;
use App\Livewire\Encuesta\Evaluacion\MisEvaluaciones;
use App\Livewire\Encuesta\Evaluacion\MostrarEvaluacion;
use App\Livewire\Encuesta\Evaluacion\RealizarEvaluacion;
use App\Livewire\Encuesta\Evaluacion\VerEvaluacion;
use App\Livewire\Encuesta\MostrarEmpresa;
use App\Livewire\Encuesta\PapeleraEmpresas;
use App\Livewire\Encuesta\Pregunta\GestionarPregunta;
use App\Livewire\Encuesta\Resultado\ReporteEvaluacion;
use App\Livewire\Encuesta\Resultado\VerResultado;
use App\Livewire\Encuesta\Usuario\CrearUsuario;
use App\Livewire\Encuesta\Usuario\EditarUsuario;
use App\Livewire\Encuesta\Usuario\MostrarUsuario;
use App\Livewire\Encuesta\Usuario\VerUsuario;
use App\Livewire\Encuesta\VerEmpresa;
use App\Livewire\MenuNavegacion;
use App\Livewire\Select2Example;
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
Route::get('/competencias/crear', CrearCompetencia::class)->name('crear-competencia');
Route::get('/competencias/revisar', RevisarComptencia::class)->name('revisar-competencia');
Route::get('/competencias/{competencia}/editar', EditarComptencia::class)->name('editar-competencia');
Route::get('/competencias/catalogo', CatalogoCompetencia::class )->name('catalogo-competencia');
Route::get('/papelera-empresas', PapeleraEmpresas::class)->name('papelera-empresas');
Route::get('/papelera-empresas', PapeleraEmpresas::class)->name('papelera-empresas');
Route::get('/gestionar-pregunta', GestionarPregunta::class)->name('gestionar-pregunta');
Route::get('/crear-evaluacion', CrearEvaluacion::class)->name('crear-evaluacion');
Route::get('/editar-evaluacion/{id}', CrearEvaluacion::class)->name('editar-evaluacion');
Route::get('/evaluaciones', MostrarEvaluacion::class)->name('mostrar-evaluaciones');
Route::get('/evaluaciones/{id}', VerEvaluacion::class)->name('ver-evaluacion');
Route::get('/evaluacion/{uuid}', RealizarEvaluacion::class)->name('realizar-evaluacion');
Route::get('/mis-evaluaciones', MisEvaluaciones::class)->name('mis-evaluaciones');
Route::get('/evaluacion-completada', \App\Livewire\Encuesta\Evaluacion\EvaluacionCompletada::class)->name('evaluacion-completada');
Route::get('/reporte-evaluacion', ReporteEvaluacion::class)->name('reporte-evaluacion');
Route::get('/ver-resultado/{evaluacion}/{usuario}', \App\Livewire\Encuesta\Resultado\VerResultado::class)->name('ver-resultado');

//crear-evaluacion  Route::get('/select2-example', Select2Example::class)->name('select2-example');
