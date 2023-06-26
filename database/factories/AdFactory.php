<?php

namespace Database\Factories;

use App\Models\Ad;
use App\Models\Advertiser;
use App\Models\Pack;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Payment;

class AdFactory extends Factory
{
    protected $model = Ad::class;

    public function definition()
    {
        // Use a 50% chance to choose text_content or audio_content 
        if ($this->faker->boolean(50)) {
            $content_type = 'text_content';
            $content_value = $this->faker->text(43);
        } else {
            $base_url = 'radioMars.com';
            $audio_filename = 'audio' . $this->faker->unique()->numberBetween(1, 1000) . '.mp3';
            $content_type = 'audio_content';
            $content_value = $base_url . '/' . $audio_filename;
        }

        // define the $pack object here
        $pack = \App\Models\Pack::all()->random();

        $decision = $this->faker->randomElement(['accepted', 'in_queue', 'rejected']);
        
        $programmed_for = null;
        $message = null;
 
        if($decision === 'accepted') {
         
            $programmed_for = $this->faker->dateTimeBetween('-2 months', '+3 months');
            $message = $this->faker->sentence;
        }
        else if($decision === 'rejected') {
            $message = $this->faker->sentence;
        }

        return [
            $content_type => $content_value,
            'status' => $this->faker->randomElement(['active', 'not_active', 'paused']),
            'pack_id' => $pack->id,
            'pack_variation' => $this->faker->numberBetween(1, $pack->variations), 
            'advertiser_id' => \App\Models\Advertiser::all()->random()->id,
            'decision' => $decision,
            'message' => $message,
            'programmed_for' => $programmed_for,
        ];
    }

    public function withPayment()
    {
        return $this->afterCreating(function (Ad $ad) {
            $payment = Payment::factory()->create(['ad_id' => $ad->id, 'advertiser_id' => $ad->advertiser_id]);
    
            if($ad->decision == 'accepted') {
                if($payment->status == 'paid') {
                    $ad->status = 'active';
                } else {
                    // If payment status is 'pending' or 'failed', set ad status as 'paused'
                    $ad->status = 'paused';
                }
            } else if($ad->decision == 'rejected') {
                $ad->status = 'not_active';
            } else if($ad->decision == 'in_queue') {
                $ad->status = 'paused';
            }
    
            $ad->save();
        });
    }
    
}
 