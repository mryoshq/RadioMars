<?php

namespace Database\Factories;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Factories\Factory;


class PaymentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // advertiser check
       // $ad = \App\Models\Ad::all()->random();
       // $advertiser_id = $ad->advertiser->id;

        return [
            'payment_method' => $this->faker->randomElement(['cc', 'transfer', 'wire']),
            'status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            
            'ad_id' => null, 
            'advertiser_id' => null,
        ];
    }
}
