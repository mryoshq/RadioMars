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
            'permissions' => json_encode(['manage_users', 'manage_roles', 'manage_ads', 'manage_content', 'manage_spots']),
        ]);

        Role::factory()->create([
            'name' => 'Validator',
            'permissions' => json_encode(['validate_ads']),
        ]);

        Role::factory()->create([
            'name' => 'Manager',
            'permissions' => json_encode(['manage_content', 'manage_spots']),
        ]);
    }
}
