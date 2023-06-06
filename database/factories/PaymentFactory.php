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
            'reservation_id' => \App\Models\Reservation::all()->random()->id,
            'amount' => $this->faker->randomFloat(2, 1, 1000), // Amount between 1.00 and 1000.00
            'payment_method' => $this->faker->randomElement(['cc', 'transfer', 'wire']),
            'status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
        ];
    }
}
