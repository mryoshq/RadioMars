<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           
            'ad_id' => \App\Models\Ad::all()->random()->id,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']), // Assigns either 'pending', 'confirmed' or 'cancelled'.
        ];
    }
} 
