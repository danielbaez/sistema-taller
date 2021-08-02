<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Administrador']);
        $role2 = Role::create(['name' => 'Almacén']);

        Permission::create(['name' => 'dashboard', 'description' => 'Ver Dashboard'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'profiles.index', 'description' => 'Ver Perfiles'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'profiles.create', 'description' => 'Crear Perfil'])->syncRoles([$role1]);
        Permission::create(['name' => 'profiles.edit', 'description' => 'Editar Perfil'])->syncRoles([$role1]);
        Permission::create(['name' => 'profiles.destroy', 'description' => 'Eliminar Perfil'])->syncRoles([$role1]);
        Permission::create(['name' => 'profiles.activate', 'description' => 'Activar Perfil'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'users.index', 'description' => 'Ver Usuarios'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.create', 'description' => 'Crear Usuario'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.edit', 'description' => 'Editar Usuario'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.destroy', 'description' => 'Eliminar Usuario'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.activate', 'description' => 'Activar Usuario'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'roles.index', 'description' => 'Ver Roles'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'roles.create', 'description' => 'Crear Rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.edit', 'description' => 'Editar Rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.destroy', 'description' => 'Eliminar Rol'])->syncRoles([$role1]);
        Permission::create(['name' => 'roles.activate', 'description' => 'Activar Rol'])->syncRoles([$role1, $role2]);
    }
}
