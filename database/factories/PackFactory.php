<?php

namespace Database\Factories;

use App\Models\Pack;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pack::class;

    /**
     * Define the model's default state. 
     *
     * @return array  
     */
    public function definition()
    {
        $price = [$this->faker->numberBetween(3000, 20000), $this->faker->numberBetween(3000, 20000)];
        
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph,
            'period' => [$this->faker->numberBetween(1, 4), $this->faker->numberBetween(1, 4)],    
            'price' => $price,
            'spots_number' => [$this->faker->numberBetween(6, 75), $this->faker->numberBetween(6, 75)],
            'days_of_week' => $this->faker->randomElements(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'], $this->faker->numberBetween(2,7 )),
            'times_of_day' => $this->faker->randomElements(['07:25:00', '10:25:00', '14:55:00', '17:25:00', '19:10:00'], $this->faker->numberBetween(2, 5)),
            'availability' => [$this->faker->boolean, $this->faker->boolean],
            'variations' => count($price),
        ];
    }
    
    
}
