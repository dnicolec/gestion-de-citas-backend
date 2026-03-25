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

        Permission::firstOrCreate(['name' => 'editar expediente']);
        Permission::firstOrCreate(['name' => 'eliminar registros']);
        Permission::firstOrCreate(['name' => 'gestionar usuarios']);
        Permission::firstOrCreate(['name' => 'ver agenda propia']);
        Permission::firstOrCreate(['name' => 'ver todas las citas']);
        Permission::firstOrCreate(['name' => 'crear pacientes']);
        Permission::firstOrCreate(['name' => 'gestionar citas']);

        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $medico = Role::firstOrCreate(['name' => 'medico']);
        $medico->givePermissionTo(['editar expediente', 'ver agenda propia']);

        $asistente = Role::firstOrCreate(['name' => 'asistente']);
        $asistente->givePermissionTo(['ver todas las citas', 'crear pacientes', 'gestionar citas']);
    }
}
