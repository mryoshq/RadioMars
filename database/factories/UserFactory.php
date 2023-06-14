<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;


class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;
 
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition() 
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'phone_number' => $this->faker->unique()->phoneNumber,

            'remember_token' => Str::random(10),
          
            'role_id' => \App\Models\Role::all()->random()->id,
        ];
    }

    public function advertiser()
    {
        $role = Role::where('name', 'User')->first();

        if (!$role) {
            throw new \Exception('User role not found');
        }

        return $this->state([
            'role_id' => $role->id,
        ]);
    }
}

