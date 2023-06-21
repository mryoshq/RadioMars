<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        Role::factory()->create([
            'name' => 'Admin',
            'permissions' => json_encode(['manage_users', 'manage_roles','manage_advertisers','manage_packs', 'manage_ads', 'manage_payments']),
        ]);

        Role::factory()->create([
            'name' => 'Validator',
            'permissions' => json_encode(['manage_ads','manage_payments']),
        ]);

        Role::factory()->create([
            'name' => 'Manager',
            'permissions' => json_encode(['manage_advertisers', 'manage_packs', 'manage_ads', 'manage_payments']),
        ]);
        Role::factory()->create([
            'name' => 'User',
            'permissions' => json_encode(['view_packs', 'launch_ads']),
        ]);
    }
}