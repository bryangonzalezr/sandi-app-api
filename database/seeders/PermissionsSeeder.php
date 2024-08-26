<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = $this->seedRoles();

        //$this->seedPermissions();

        /* $roles['nutricionista']->givePermissionTo([
            'nutritional_plan.create',
            'nutritional_plan.view_any',
            'nutritional_plan.update_any',
            'nutritional_plan.delete_any',
            'nutritional_plan.view_own',
            'nutritional_plan.update_own',
            'nutritional_plan.delete_own',
            'users.create',
            'users.view_any',
            'users.update_any',
            'users.delete_any',
            'users.view_patient_users',
            'users.update_patient_users',
            'users.delete_patient_users',
            'roles.assign_patient_user',
            'roles.retract_patient_user',
        ]);

        $roles['paciente']->givePermissionTo([
            'nutritional_plan.view_own',
        ]);

        $roles['usuario_basico']->givePermissionTo([
        ]); */
    }

    /**
     * @return array<string, Role>
     */
    protected function seedRoles(): array
    {
        return [
            // SUPERADMIN
            'superadmin' => Role::firstOrCreate([
                'id'          => 1,
                'name'        => 'superadmin',
                'description' => 'SuperAdmin de Sandi-App (todos los permisos implicitos)',
            ]),
            // ROLES BASE
            'nutricionista' => Role::firstOrCreate([
                'id'          => 2,
                'name'        => 'nutricionista',
                'description' => 'Usuario Nutricionista (permisos medios)',
            ]),
            'paciente' => Role::firstOrCreate([
                'id'          => 3,
                'name'        => 'paciente',
                'description' => 'Usuario Paciente (permisos mínimos)',
            ]),
            'usuario_basico' => Role::firstOrCreate([
                'id'          => 4,
                'name'        => 'usuario_basico',
                'description' => 'Usuario básico (permisos mínimos)',
            ]),
        ];
    }

    /* protected function seedPermissions(): void
    {
        Permission::create([
            'name' => 'nutritional_plan.create',
            'description' => 'Usuario puede crear un Plan Nutricional'
        ]);
        Permission::create([
            'name' => 'nutritional_plan.view_any',
            'description' => 'Usuario puede ver información de cualquier Plan Nutricional'
        ]);
        Permission::create([
            'name' => 'nutritional_plan.update_any',
            'description' => 'Usuario puede actualizar información de cualquier Plan Nutricional'
        ]);
        Permission::create([
            'name' => 'nutritional_plan.delete_any',
            'description' => 'Usuario puede eliminar cualquier Plan Nutricional'
        ]);
        Permission::create([
            'name' => 'nutritional_plan.view_own',
            'description' => 'Usuario puede ver información de su Plan Nutricional'
        ]);
        Permission::create([
            'name' => 'users.create',
            'description' => 'Usuario puede crear un Usuario'
        ]);
        Permission::create([
            'name' => 'users.view_any',
            'description' => 'Usuario puede ver información de cualquier Usuario'
        ]);
        Permission::create([
            'name' => 'users.update_any',
            'description' => 'Usuario puede actualizar información de cualquier Usuario'
        ]);
        Permission::create([
            'name' => 'users.delete_any',
            'description' => 'Usuario puede eliminar cualquier Usuario'
        ]);
        Permission::create([
            'name' => 'users.view_patient_users',
            'description' => 'Usuario puede ver información de sus Usuarios Pacientes'
        ]);
        Permission::create([
            'name' => 'users.delete_patient_users',
            'description' => 'Usuario puede eliminar sus Usuarios Pacientes'
        ]);
        Permission::create([
            'name' => 'roles.assign_patient_user',
            'description' => 'Usuario puede asignar Rol Paciente'
        ]);
        Permission::create([
            'name' => 'roles.retract_patient_user',
            'description' => 'Usuario puede desasignar Rol Paciente'
        ]);
    } */
}
