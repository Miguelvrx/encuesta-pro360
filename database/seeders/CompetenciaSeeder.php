<?php

namespace Database\Seeders;

use App\Models\CategoriaCompetencia;
use App\Models\Competencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompetenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
           // Buscamos las categorías por su nombre para asignar las competencias
        $catGeneral = CategoriaCompetencia::where('categoria', 'Generales / Organizacionales')->first();
        $catCardinales = CategoriaCompetencia::where('categoria', 'Cardinales / Esenciales')->first();
        $catGerencial = CategoriaCompetencia::where('categoria', 'Gerenciales / Liderazgo')->first();

        // --- Competencia 1: Liderazgo ---
        if ($catGerencial) {
            $liderazgo = Competencia::create([
                'nombre_competencia' => 'Liderazgo',
                'definicion_competencia' => 'Capacidad para conducir y motivar equipos, desarrollar talento y mantener un clima organizacional positivo y desafiante.',
                'categoria_id_competencia' => $catGerencial->id_categoria_competencia,
            ]);

            $liderazgo->niveles()->createMany([
                ['nombre_nivel' => 'Sobresaliente', 'descripcion_nivel' => 'Diseña estrategias y métodos de trabajo que aseguran la conducción de personas, el desarrollo de talento y el compromiso organizacional a largo plazo.'],
                ['nombre_nivel' => 'Competente', 'descripcion_nivel' => 'Propone y gestiona procesos que favorecen la conducción de equipos y el desarrollo de colaboradores, manteniendo un clima organizacional positivo a mediano plazo.'],
                ['nombre_nivel' => 'En Desarrollo', 'descripcion_nivel' => 'Sugiere y aplica nuevas formas de trabajo que fortalecen la conducción de personas y el compromiso del equipo en el corto plazo.'],
                ['nombre_nivel' => 'Necesita Mejorar', 'descripcion_nivel' => 'Conduce personas y promueve el desarrollo de talento, manteniendo un clima organizacional armónico dentro de su equipo de trabajo.'],
            ]);
        }

        // --- Competencia 2: Compromiso ---
        if ($catCardinales) {
            $compromiso = Competencia::create([
                'nombre_competencia' => 'Compromiso',
                'definicion_competencia' => 'Sentir como propios los objetivos de la organización. Apoyar e instrumentar decisiones comprometido por completo con el logro de objetivos comunes.',
                'categoria_id_competencia' => $catCardinales->id_categoria_competencia,
            ]);

            $compromiso->niveles()->createMany([
                ['nombre_nivel' => 'Sobresaliente', 'descripcion_nivel' => 'Inspira a otros a través de su dedicación, alineando sus acciones y las del equipo con la visión y estrategia de la organización, incluso en circunstancias difíciles.'],
                ['nombre_nivel' => 'Competente', 'descripcion_nivel' => 'Demuestra un fuerte compromiso con los objetivos, asumiendo responsabilidad y buscando activamente formas de contribuir al éxito del equipo y la empresa.'],
                ['nombre_nivel' => 'En Desarrollo', 'descripcion_nivel' => 'Cumple de manera fiable con sus responsabilidades y demuestra una actitud positiva hacia los objetivos de la organización.'],
                ['nombre_nivel' => 'Necesita Mejorar', 'descripcion_nivel' => 'Realiza las tareas asignadas, pero podría mostrar una mayor conexión con los objetivos generales de la organización.'],
            ]);
        }
        
        // --- Competencia 3: Trabajo en Equipo (Ejemplo adicional) ---
        if ($catGeneral) {
            $trabajoEquipo = Competencia::create([
                'nombre_competencia' => 'Trabajo en Equipo',
                'definicion_competencia' => 'Capacidad para colaborar y cooperar con los demás, formando parte de un grupo y trabajando juntos para alcanzar objetivos comunes.',
                'categoria_id_competencia' => $catGeneral->id_categoria_competencia,
            ]);
             $trabajoEquipo->niveles()->createMany([
                ['nombre_nivel' => 'Sobresaliente', 'descripcion_nivel' => 'Fomenta activamente un clima de colaboración, resuelve conflictos y promueve la participación de todos los miembros para maximizar el rendimiento del equipo.'],
                ['nombre_nivel' => 'Competente', 'descripcion_nivel' => 'Colabora eficazmente, comparte información y apoya a sus compañeros para lograr los objetivos del equipo.'],
            ]);
        }
    }
    
}
