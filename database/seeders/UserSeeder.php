<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\StructureEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create admin
        $admin = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@bureauisosud.com',
            'role' => RoleEnum::ADMIN
        ]);
        $admin->assignRole(RoleEnum::ADMIN);


        // create user
        $user = \App\Models\User::factory()->create([
            'name' => 'User',
            'email' => 'user@bureauisosud.com',
            'role' => RoleEnum::STRUCTURE,
            'domain' => StructureEnum::DOMAIN['Economique'],
            'sector' => StructureEnum::SECTOR['Publique']
        ]);
        $user->assignRole(RoleEnum::STRUCTURE);
    }
}
