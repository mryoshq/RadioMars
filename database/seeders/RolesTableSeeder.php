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
            'permissions' => ['manage_users', 'manage_roles','manage_advertisers','manage_packs', 'manage_ads', 'manage_payments'],
        ]);

        Role::factory()->create([
            'name' => 'Validator',
            'permissions' => ['manage_ads','manage_payments'],
        ]);

        Role::factory()->create([
            'name' => 'Manager',
            'permissions' => ['manage_advertisers', 'manage_packs', 'manage_ads', 'manage_payments'],
        ]);
        Role::factory()->create([
            'name' => 'User',
            'permissions' => ['view_packs', 'launch_ads'],
        ]);
    }
}