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
        return [
            'user_id' => \App\Models\User::all()->random()->id,
            'reservation_id' => \App\Models\Reservation::all()->random()->id,
            'amount' => $this->faker->randomFloat(2, 3000, 17000), 
            'payment_method' => $this->faker->randomElement(['cc', 'transfer', 'wire']),
            'status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
 