<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /**
     * Run the database seeds.
     */
    
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear Permisos
        $permissions = [
            // Usuarios
            // 'ver-usuarios',
            // 'crear-usuarios',
            // 'editar-usuarios',
            // 'eliminar-usuarios',
            
            // Empresas
            'ver-empresas',
            'crear-empresas',
            'editar-empresas',
            // 'eliminar-empresas',
            
            // Departamentos
            // 'ver-departamentos',
            // 'crear-departamentos',
            // 'editar-departamentos',
            // 'eliminar-departamentos',
            
            // Evaluaciones
            // 'ver-evaluaciones',
            // 'crear-evaluaciones',
            // 'editar-evaluaciones',
            // 'eliminar-evaluaciones',
            // 'completar-evaluaciones',
            
            // Reportes
            // 'ver-reportes',
            // 'exportar-reportes',
            // 'ver-ranking',
            
            // Competencias
            // 'ver-competencias',
            // 'crear-competencias',
            // 'editar-competencias',
            // 'eliminar-competencias',
            
            // Configuración
            // 'ver-configuracion',
            // 'editar-configuracion',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Crear Roles y asignar permisos

        // 1. Super Admin - Acceso total
        $superAdmin = Role::create(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // 2. Administrador - Casi todo menos configuración avanzada
        $admin = Role::create(['name' => 'Administrador']);
        $admin->givePermissionTo([
            // 'ver-usuarios', 'crear-usuarios', 'editar-usuarios',
            'ver-empresas', 'crear-empresas', 'editar-empresas',
            // 'ver-departamentos', 'crear-departamentos', 'editar-departamentos',
            // 'ver-evaluaciones', 'crear-evaluaciones', 'editar-evaluaciones',
            // 'ver-reportes', 'exportar-reportes', 'ver-ranking',
            // 'ver-competencias', 'crear-competencias', 'editar-competencias',
        ]);

        // 3. Recursos Humanos - Gestión de personal y evaluaciones
        $rrhh = Role::create(['name' => 'Recursos Humanos']);
        $rrhh->givePermissionTo([
               'ver-empresas',
          
        ]);

      //  4. Gerente - Ver reportes de su área
        $gerente = Role::create(['name' => 'Gerente']);
        $gerente->givePermissionTo([
           'crear-empresas',
        ]);

        // // 5. Empleado - Solo completar sus evaluaciones
        // $empleado = Role::create(['name' => 'Empleado']);
        // $empleado->givePermissionTo([
        //     'completar-evaluaciones',
        // ]);

        // // 6. Observador - Solo lectura
        // $observador = Role::create(['name' => 'Observador']);
        // $observador->givePermissionTo([
        //     'ver-usuarios',
        //     'ver-empresas',
        //     'ver-departamentos',
        //     'ver-evaluaciones',
        //     'ver-reportes',
        //     'ver-competencias',
        // ]);

        // Asignar rol Super Admin al primer usuario (si existe)
        $user = User::first();
        if ($user) {
            $user->assignRole('Super Admin');
            $this->command->info("✅ Rol 'Super Admin' asignado a: {$user->name}");
        }

        $this->command->info('✅ Roles y permisos creados exitosamente');
        $this->command->info('📊 Total de permisos: ' . Permission::count());
        $this->command->info('🎭 Total de roles: ' . Role::count());
    }
}

