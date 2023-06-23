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
            'phone_number' => $this->faker->unique()->regexify('^0[67][0-9]{8}$'),
            'remember_token' => Str::random(10),
            'created_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
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

