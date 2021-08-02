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

        Permission::create(['name' => 'dashboard'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'profiles.index'])->syncRoles([$role1, $role2]);
        Permission::create(['name' => 'profiles.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'profiles.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'profiles.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'profiles.activate'])->syncRoles([$role1, $role2]);

        Permission::create(['name' => 'users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.create'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.activate'])->syncRoles([$role1, $role2]);
    }
}
