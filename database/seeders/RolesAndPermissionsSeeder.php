<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
{
    // Define permissions
    $permissions = [
        'create invoice',
        'view invoice',
        'delete invoice',
        'edit invoice',
    ];

    // Create permissions
    foreach ($permissions as $permission) {
        Permission::firstOrCreate(['name' => $permission]);
    }

    // Create roles and assign permissions
    $adminRole = Role::firstOrCreate(['name' => 'admin']);
    $adminRole->givePermissionTo(Permission::all());

    $managerRole = Role::firstOrCreate(['name' => 'manager']);
    $managerRole->givePermissionTo(['view invoice', 'create invoice']);

    $staffRole = Role::firstOrCreate(['name' => 'staff']);
    $staffRole->givePermissionTo(['view invoice']);
}
}
