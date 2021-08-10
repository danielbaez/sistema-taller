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
        $role2 = Role::create(['name' => 'Vendedor', 'status' => 1]);
        $role3 = Role::create(['name' => 'Almacén', 'status' => 1]);

        Permission::create(['name' => 'dashboard', 'description' => 'Ver Dashboard', 'status' => 1])->syncRoles([$role1->id, $role2->id, $role3->id]);

        Permission::create(['name' => 'roles.index', 'description' => 'Ver Roles', 'status' => 1])->syncRoles([$role1->id, $role3->id]);
        Permission::create(['name' => 'roles.create', 'description' => 'Crear Rol', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.edit', 'description' => 'Editar Rol', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.destroy', 'description' => 'Eliminar Rol', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'roles.activate', 'description' => 'Activar Rol', 'status' => 1])->syncRoles([$role1->id, $role3->id]);

        Permission::create(['name' => 'users.index', 'description' => 'Ver Usuarios', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.create', 'description' => 'Crear Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.edit', 'description' => 'Editar Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.destroy', 'description' => 'Eliminar Usuario', 'status' => 1])->syncRoles([$role1->id]);
        Permission::create(['name' => 'users.activate', 'description' => 'Activar Usuario', 'status' => 1])->syncRoles([$role1->id, $role3->id]);
    }
}
