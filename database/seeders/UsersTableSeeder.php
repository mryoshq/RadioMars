<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // couple managers and validators
        User::factory()->count(2)->create(['role_id' => 2]);
        User::factory()->count(3)->create(['role_id' => 3]);

        // an admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), // password
            'phone_number' => '0600000000',
            'role_id' => 1,
        ]);

        // rest of the users will be advertisers
    }
}