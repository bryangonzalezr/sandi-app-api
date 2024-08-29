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

        $this->seedPermissions();

        $roles['nutricionista']->givePermissionTo([
            'nutritional_plan.create',
            'nutritional_plan.view',
            'nutritional_plan.update',
            'nutritional_plan.delete',
            'nutritional_profile.create',
            'nutritional_profile.view',
            'nutritional_profile.update',
            'nutritional_profile.delete',
            'recipe.create',
            'recipe.view',
            'recipe.view_any',
            'recipe.update',
            'recipe.delete',
            'recipe.generate',
            'menu.create',
            'menu.view',
            'menu.update',
            'menu.delete',
            'menu.generate',
            'suscription.view',
            'suscription.create',
            'suscription.delete',
            'contact_cards.create',
            'contact_cards.update',
            'contact_cards.delete',
            'contact_cards.view',
            'users.view_own',
            'users.view_patient_users',
            'users.create_patient_users',
            'users.delete_patient_users',
            'roles.assign_patient_user',
            'roles.retract_patient_user',
        ]);

        $roles['paciente']->givePermissionTo([
            'nutritional_plan.view_own',
            'nutritional_profile.view_own',
            'recipe.create',
            'recipe.view',
            'recipe.delete',
            'recipe.generate',
            'menu.create',
            'menu.view',
            'menu.delete',
            'users.view_own',
            'shopping_list.create',
            'shopping_list.view',
            'shopping_list.delete',
        ]);

        $roles['usuario_basico']->givePermissionTo([
            'recipe.create',
            'recipe.view',
            'recipe.delete',
            'recipe.generate',
            'users.view_own',
            'contact_cards.view',
        ]);
    }

    /**
     * @return array<string, Role>
     */
    protected function seedRoles(): array
    {
        return [
            // SUPERADMIN
            'superadmin' => Role::firstOrCreate([
                'id'           => 1,
                'name'         => 'superadmin',
                'display_name' => 'Super Admin',
                'description'  => 'SuperAdmin de Sandi-App (todos los permisos implicitos)',
            ]),
            // ROLES BASE
            'nutricionista' => Role::firstOrCreate([
                'id'           => 2,
                'name'         => 'nutricionista',
                'display_name' => 'Nutricionista',
                'description'  => 'Usuario Nutricionista (permisos altos)',
            ]),
            'paciente' => Role::firstOrCreate([
                'id'           => 3,
                'name'         => 'paciente',
                'display_name' => 'Paciente',
                'description'  => 'Usuario Paciente (permisos medios)',
            ]),
            'usuario_basico' => Role::firstOrCreate([
                'id'           => 4,
                'name'         => 'usuario_basico',
                'display_name' => 'Usuario Básico',
                'description'  => 'Usuario básico (permisos mínimos)',
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
            'name' => 'users.create_patient_users',
            'description' => 'Usuario puede agregar usuarios como Pacientes'
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

        //Permisos tarjetas de contacto

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

        //Permisos lista de compras

        //Paciente
        Permission::create([
            'name' => 'shopping_list.create',
            'description' => 'Usuario puede crear una lista de compras basado en un menu'
        ]);
        Permission::create([
            'name' => 'shopping_list.view',
            'description' => 'Usuario puede visualizar sus listas de compras'
        ]);
        Permission::create([
            'name' => 'shopping_list.delete',
            'description' => 'Usuario puede eliminar una lista de compras'
        ]);




    }
}
