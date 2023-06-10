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
            'reservation_id' => \App\Models\Reservation::all()->random()->id,
            'pack_id' => \App\Models\Pack::all()->random()->id,
            'time_of_day' => $this->faker->randomElement(json_decode(\App\Models\Pack::all()->random()->times_of_day, true)),
            'day_of_week' => $this->faker->randomElement(json_decode(\App\Models\Pack::all()->random()->days_of_week, true)),
            
            
            'status' => $this->faker->randomElement(['booked', 'available']), // Assigns either 'booked' or 'available'.
        ];
    }
}
