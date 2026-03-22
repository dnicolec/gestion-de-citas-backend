<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'editar expediente']);
        Permission::create(['name' => 'eliminar registros']);
        Permission::create(['name' => 'gestionar usuarios']);
        Permission::create(['name' => 'ver agenda propia']);
        Permission::create(['name' => 'ver todas las citas']);
        Permission::create(['name' => 'crear pacientes']);
        Permission::create(['name' => 'gestionar citas']);

        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $medico = Role::create(['name' => 'medico']);
        $medico->givePermissionTo(['editar expediente', 'ver agenda propia']);

        $asistente = Role::create(['name' => 'asistente']);
        $asistente->givePermissionTo(['ver todas las citas', 'crear pacientes', 'gestionar citas']);
    }
}
