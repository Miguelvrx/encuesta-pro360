<?php

namespace Database\Seeders;

use App\Models\CategoriaCompetencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriaCompetenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            'Generales / Organizacionales', // Para todos en la empresa
            'Cardinales / Esenciales',      // Competencias clave del negocio
            'Gerenciales / Liderazgo',      // Para roles de jefatura
            'Por Área / Específicas',       // Técnicas o funcionales (Ventas, TI, etc.)
            'Educación / Formación',        // Relacionadas al aprendizaje y desarrollo
            'Valores Corporativos',         // Competencias basadas en los valores de la empresa
        ];

        foreach ($categorias as $categoria) {
            CategoriaCompetencia::create(['categoria' => $categoria]);
        }
    }
}
