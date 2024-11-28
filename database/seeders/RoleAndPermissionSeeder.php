<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'ver usuarios']);
        Permission::create(['name' => 'crear usuarios']);
        Permission::create(['name' => 'editar usuarios']);
        Permission::create(['name' => 'eliminar usuarios']);

        // Crear roles y asignar permisos
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $encargado = Role::create(['name' => 'encargado']);
        $encargado->givePermissionTo(['ver usuarios', 'editar usuarios']);

        $proveedor = Role::create(['name' => 'proveedor']);
        $proveedor->givePermissionTo(['ver usuarios', 'editar usuarios']);

        $usuario = Role::create(['name' => 'cliente']);
        $usuario->givePermissionTo(['ver usuarios']);
    }
}
