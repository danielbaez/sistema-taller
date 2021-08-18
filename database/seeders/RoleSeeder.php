<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;
use App\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role1 = Role::create(['name' => 'Administrador', 'status' => 1]);
        $role2 = Role::create(['name' => 'Técnico', 'status' => 1]);

        Permission::create(['name' => 'dashboard', 'description' => 'Ver Dashboard', 'status' => 1])->syncRoles([$role1->id, $role2->id]);

        Permission::create(['name' => 'roles.index', 'description' => 'Ver Roles', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.create', 'description' => 'Crear Rol', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.edit', 'description' => 'Editar Rol', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.destroy', 'description' => 'Eliminar Rol', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.activate', 'description' => 'Activar Rol', 'status' => 1])->syncRoles([$role1->id]);

        Permission::create(['name' => 'users.index', 'description' => 'Ver Usuarios', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.create', 'description' => 'Crear Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.edit', 'description' => 'Editar Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.destroy', 'description' => 'Eliminar Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.activate', 'description' => 'Activar Usuario', 'status' => 1])->syncRoles([$role1->id]);

        Permission::create(['name' => 'usersAccounts.index', 'description' => 'Ver Roles de Usuarios', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'usersAccounts.create', 'description' => 'Crear Rol de Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'usersAccounts.edit', 'description' => 'Editar Rol de Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'usersAccounts.destroy', 'description' => 'Eliminar Rol de Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'usersAccounts.activate', 'description' => 'Activar Rol de Usuario', 'status' => 1])->syncRoles([$role1->id]);

        Permission::create(['name' => 'branches.index', 'description' => 'Ver Sucursales', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'branches.create', 'description' => 'Crear Sucursal', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'branches.edit', 'description' => 'Editar Sucursal', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'branches.destroy', 'description' => 'Eliminar Sucursal', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'branches.activate', 'description' => 'Activar Sucursal', 'status' => 1])->syncRoles([$role1->id]);

        Permission::create(['name' => 'configurations.index', 'description' => 'Ver Configuración', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'configurations.edit', 'description' => 'Editar Configuración', 'status' => 1])->syncRoles([$role1->id]);

        Permission::create(['name' => 'categories.index', 'description' => 'Ver Categorías', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'categories.create', 'description' => 'Crear Categoría', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'categories.edit', 'description' => 'Editar Categoría', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'categories.destroy', 'description' => 'Eliminar Categoría', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'categories.activate', 'description' => 'Activar Categoría', 'status' => 1])->syncRoles([$role1->id, $role2->id]);

        Permission::create(['name' => 'brands.index', 'description' => 'Ver Marcas', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'brands.create', 'description' => 'Crear Marca', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'brands.edit', 'description' => 'Editar Marca', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'brands.destroy', 'description' => 'Eliminar Marca', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'brands.activate', 'description' => 'Activar Marca', 'status' => 1])->syncRoles([$role1->id, $role2->id]);

        Permission::create(['name' => 'models.index', 'description' => 'Ver Modelos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'models.create', 'description' => 'Crear Modelo', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'models.edit', 'description' => 'Editar Modelo', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'models.destroy', 'description' => 'Eliminar Modelo', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'models.activate', 'description' => 'Activar Modelo', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
    }
}
