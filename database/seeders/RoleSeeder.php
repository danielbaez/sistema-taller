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

        Permission::create(['name' => 'dashboard', 'description' => 'Ver Dashboard', 'resource' => 'Dashboard', 'status' => 1])->syncRoles([$role1->id, $role2->id]);

        Permission::create(['name' => 'roles.index', 'description' => 'Ver Roles', 'resource' => 'Roles', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.create', 'description' => 'Crear Rol', 'resource' => 'Roles', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.edit', 'description' => 'Editar Rol', 'resource' => 'Roles', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.destroy', 'description' => 'Eliminar Rol', 'resource' => 'Roles', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.activate', 'description' => 'Activar Rol', 'resource' => 'Roles', 'status' => 1])->syncRoles([$role1->id]);

        Permission::create(['name' => 'users.index', 'description' => 'Ver Usuarios', 'resource' => 'Usuarios', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.create', 'description' => 'Crear Usuario', 'resource' => 'Usuarios', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.edit', 'description' => 'Editar Usuario', 'resource' => 'Usuarios', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.destroy', 'description' => 'Eliminar Usuario', 'resource' => 'Usuarios', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.activate', 'description' => 'Activar Usuario', 'resource' => 'Usuarios', 'status' => 1])->syncRoles([$role1->id]);

        Permission::create(['name' => 'usersAccounts.index', 'description' => 'Ver Roles de Usuarios', 'resource' => 'Cuentas de Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'usersAccounts.create', 'description' => 'Crear Rol de Usuario', 'resource' => 'Cuentas de Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'usersAccounts.edit', 'description' => 'Editar Rol de Usuario', 'resource' => 'Cuentas de Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'usersAccounts.destroy', 'description' => 'Eliminar Rol de Usuario', 'resource' => 'Cuentas de Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'usersAccounts.activate', 'description' => 'Activar Rol de Usuario', 'resource' => 'Cuentas de Usuario', 'status' => 1])->syncRoles([$role1->id]);

        Permission::create(['name' => 'branches.index', 'description' => 'Ver Sucursales', 'resource' => 'Sucursales', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'branches.create', 'description' => 'Crear Sucursal', 'resource' => 'Sucursales', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'branches.edit', 'description' => 'Editar Sucursal', 'resource' => 'Sucursales', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'branches.destroy', 'description' => 'Eliminar Sucursal', 'resource' => 'Sucursales', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'branches.activate', 'description' => 'Activar Sucursal', 'resource' => 'Sucursales', 'status' => 1])->syncRoles([$role1->id]);

        Permission::create(['name' => 'configurations.index', 'description' => 'Ver Configuración', 'resource' => 'Configuración', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'configurations.edit', 'description' => 'Editar Configuración', 'resource' => 'Configuración', 'status' => 1])->syncRoles([$role1->id]);

        Permission::create(['name' => 'clients.index', 'description' => 'Ver Clientes', 'resource' => 'Clientes', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'clients.create', 'description' => 'Crear Cliente', 'resource' => 'Clientes', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'clients.edit', 'description' => 'Editar Cliente', 'resource' => 'Clientes', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'clients.destroy', 'description' => 'Eliminar Cliente', 'resource' => 'Clientes', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'clients.activate', 'description' => 'Activar Cliente', 'resource' => 'Clientes', 'status' => 1])->syncRoles([$role1->id, $role2->id]);

        Permission::create(['name' => 'categories.index', 'description' => 'Ver Categorías', 'resource' => 'Categorías', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'categories.create', 'description' => 'Crear Categoría', 'resource' => 'Categorías', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'categories.edit', 'description' => 'Editar Categoría', 'resource' => 'Categorías', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'categories.destroy', 'description' => 'Eliminar Categoría', 'resource' => 'Categorías', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'categories.activate', 'description' => 'Activar Categoría', 'resource' => 'Categorías', 'status' => 1])->syncRoles([$role1->id, $role2->id]);

        Permission::create(['name' => 'brands.index', 'description' => 'Ver Marcas', 'resource' => 'Marcas', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'brands.create', 'description' => 'Crear Marca', 'resource' => 'Marcas', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'brands.edit', 'description' => 'Editar Marca', 'resource' => 'Marcas', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'brands.destroy', 'description' => 'Eliminar Marca', 'resource' => 'Marcas', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'brands.activate', 'description' => 'Activar Marca', 'resource' => 'Marcas', 'status' => 1])->syncRoles([$role1->id, $role2->id]);

        Permission::create(['name' => 'models.index', 'description' => 'Ver Modelos', 'resource' => 'Modelos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'models.create', 'description' => 'Crear Modelo', 'resource' => 'Modelos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'models.edit', 'description' => 'Editar Modelo', 'resource' => 'Modelos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'models.destroy', 'description' => 'Eliminar Modelo', 'resource' => 'Modelos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'models.activate', 'description' => 'Activar Modelo', 'resource' => 'Modelos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);

        Permission::create(['name' => 'devices.index', 'description' => 'Ver Equipos', 'resource' => 'Dispositivos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'devices.create', 'description' => 'Crear Equipo', 'resource' => 'Dispositivos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'devices.edit', 'description' => 'Editar Equipo', 'resource' => 'Dispositivos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'devices.destroy', 'description' => 'Eliminar Equipo', 'resource' => 'Dispositivos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
        Permission::create(['name' => 'devices.activate', 'description' => 'Activar Equipo', 'resource' => 'Dispositivos', 'status' => 1])->syncRoles([$role1->id, $role2->id]);
    }
}
