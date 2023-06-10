<?php

namespace Database\Factories;

use App\Models\Ad;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'campaign_id' => \App\Models\Campaign::all()->random()->id,
            'pack_id' => \App\Models\Pack::all()->random()->id,
            'text_content' => $this->faker->text(200),
            'audio_content' => $this->faker->text(200), 
            'status' => $this->faker->randomElement(['active', 'not_active', 'paused']), // Assigns one of the possible status values.
        ];
    }
}
