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
        $domain_names = ['Céramique', 'Maroquinerie', 'Tapisserie', 'Bijouterie', 'Boiserie', 'Métallurgie', 'Textile', 'Vannerie', 'Broderie', 'Poterie'];

        return [
            'domain' => $this->faker->randomElement($domain_names),
            'firm' => $this->faker->unique()->company,
            'user_id' => User::factory()->advertiser(), 
            
        ];
    }
}
