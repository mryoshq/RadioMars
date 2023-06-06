<?php

namespace Database\Factories;

use App\Models\Spot;
use Illuminate\Database\Eloquent\Factories\Factory;

class SpotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Spot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ad_id' => \App\Models\Ad::all()->random()->id,
            'day_of_week' => $this->faker->dayOfWeek, // Generates a random day of the week.
            'time_of_day' => $this->faker->time($format = 'H:i:s'), // Generates a random time.
            'status' => $this->faker->randomElement(['booked', 'available']), // Assigns either 'booked' or 'available'.
        ];
    }
}
