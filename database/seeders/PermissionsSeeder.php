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

    protected function seedPermissions(): void
    {
        //Permisos plan nutricional

        //Nutricionista
        Permission::create([
            'name' => 'nutritional_plan.create',
            'description' => 'Usuario puede crear un Plan Nutricional'
        ]);
        Permission::create([
            'name' => 'nutritional_plan.view',
            'description' => 'Usuario puede ver información de cualquier Plan Nutricional'
        ]);
        Permission::create([
            'name' => 'nutritional_plan.update',
            'description' => 'Usuario puede actualizar información de cualquier Plan Nutricional'
        ]);
        Permission::create([
            'name' => 'nutritional_plan.delete',
            'description' => 'Usuario puede archivar cualquier Plan Nutricional'
        ]);

        //Paciente
        Permission::create([
            'name' => 'nutritional_plan.view_own',
            'description' => 'Usuario puede ver información de su Plan Nutricional actual'
        ]);

        //Permisos perfil nutricional

        //Nutricionista
        Permission::create([
            'name' => 'nutritional_profile.create',
            'description' => 'Usuario puede crear un Perfil Nutricional'
        ]);
        Permission::create([
            'name' => 'nutritional_profile.view',
            'description' => 'Usuario puede ver información de cualquier Perfil Nutricional'
        ]);
        Permission::create([
            'name' => 'nutritional_profile.update',
            'description' => 'Usuario puede actualizar información de cualquier Plan Nutricional'
        ]);
        Permission::create([
            'name' => 'nutritional_profile.delete',
            'description' => 'Usuario puede eliminar cualquier Perfil Nutricional'
        ]);

        //Paciente
        Permission::create([
            'name' => 'nutritional_profile.view_own',
            'description' => 'Usuario puede ver información de su Perfil Nutricional'
        ]);

        //Permisos recetas

         //Nutricionista y Paciente
         Permission::create([
            'name' => 'recipe.create',
            'description' => 'Usuario puede crear una Receta'
        ]);
        Permission::create([
            'name' => 'recipe.view',
            'description' => 'Usuario puede ver información de sus recetas'
        ]);
        Permission::create([
            'name' => 'recipe.update',
            'description' => 'Usuario puede actualizar información de sus recetas'
        ]);
        Permission::create([
            'name' => 'recipe.delete',
            'description' => 'Usuario puede eliminar sus recetas'
        ]);

        //Paciente y Usuario Básico
        Permission::create([
            'name' => 'recipe.generate',
            'description' => 'Usuario puede generar recetas con el asistente'
        ]);

        //Nutricionista
        Permission::create([
            'name' => 'recipe.view_any',
            'description' => 'Usuario puede ver información de las recetas de sus pacientes'
        ]);

        //Permisos menus

        //Nutricionista
        Permission::create([
            'name' => 'menu.update',
            'description' => 'Usuario puede actualizar información de sus Menús guardados'
        ]);

        //Nutricionista y Paciente
        Permission::create([
            'name' => 'menu.create',
            'description' => 'Usuario puede crear un Menú Diario, Semanal o Mensual'
        ]);
        Permission::create([
            'name' => 'menu.view',
            'description' => 'Usuario puede ver información de sus Menús guardados'
        ]);
        Permission::create([
            'name' => 'menu.delete',
            'description' => 'Usuario puede eliminar sus Menús guardados'
        ]);
        Permission::create([
            'name' => 'menu.generate',
            'description' => 'Usuario puede generar Menús con el asistente'
        ]);

        //Permisos suscripción

        //Nutricionista
        Permission::create([
            'name' => 'suscription.view',
            'description' => 'Usuario puede ver información de sus suscripciones'
        ]);
        Permission::create([
            'name' => 'suscription.create',
            'description' => 'Usuario puede crear una suscripción'
        ]);
        Permission::create([
            'name' => 'suscription.delete',
            'description' => 'Usuario puede cancelar suscricpción'
        ]);

        //Permisos usuarios

        //SuperAdmin
        Permission::create([
            'name' => 'users.create',
            'description' => 'Usuario puede crear un Usuario'
        ]);

        //Nutricionista, Paciente y Usuario Básico
        Permission::create([
            'name' => 'users.view_own',
            'description' => 'Usuario puede ver su información '
        ]);
        Permission::create([
            'name' => 'users.update_own',
            'description' => 'Usuario puede actualizar su información'
        ]);

        // Permisos pacientes asociados

        //Nutricionista
        Permission::create([
            'name' => 'users.view_patient_users',
            'description' => 'Usuario puede ver información de sus Usuarios Pacientes'
        ]);
        Permission::create([
            'name' => 'users.delete_patient_users',
            'description' => 'Usuario puede desvincularse de sus Usuarios Pacientes'
        ]);

        Permission::create([
            'name' => 'roles.assign_patient_user',
            'description' => 'Usuario puede asignar Rol Paciente'
        ]);
        Permission::create([
            'name' => 'roles.retract_patient_user',
            'description' => 'Usuario puede desasignar Rol Paciente'
        ]);

        //Permisos tarjeatas de contacto

        //Nutricionista
        Permission::create([
            'name' => 'contact_cards.create',
            'description' => 'Usuario puede crear una tarjeta de contacto'
        ]);

        Permission::create([
            'name' => 'contact_cards.update',
            'description' => 'Usuario puede actualizar información de su tarjeta de contacto'
        ]);

        Permission::create([
            'name' => 'contact_cards.delete',
            'description' => 'Usuario puede eliminar sus tarjetas de contacto'
        ]);

        //Nutricionista y Usuario Básico
        Permission::create([
            'name' => 'contact_cards.view',
            'description' => 'Usuario puede ver información de una tarjeta de contacto'
        ]);


    }
}
