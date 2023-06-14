<?php

namespace Database\Factories;

use App\Models\Advertiser;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertiserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string 
     */
    protected $model = Advertiser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $domain_names = ['artisanal1', 'artisanal2', 'artisanal3', 'artisanal4', 'artisanal5', 'artisanal6', 'artisanal7', 'artisanal8', 'artisanal9', 'artisanal10'];

        return [
            'domain' => $this->faker->randomElement($domain_names),
            'firm' => $this->faker->unique()->company,
            'user_id' => User::factory()->advertiser(),
            
        ];
    }
}
