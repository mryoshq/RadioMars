<?php

namespace Database\Seeders;

use App\Models\Pack;
use Illuminate\Database\Seeder;

class PacksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Pack::factory()->create([
            'name' => 'Pack Classique 1 semaine',
            'price' => 10500,
            'spots_number' => 35,
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'times_of_day' => json_encode(['07:25:00', '10:25:00', '14:55:00', '17:25:00', '19:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Pack Classique 2 semaines',
            'price' => 17500,
            'spots_number' => 70,
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'times_of_day' => json_encode(['07:25:00', '10:25:00', '14:55:00', '17:25:00', '19:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Pack Sabahyat 1 semaine',
            'price' => 7500,
            'spots_number' => 15,
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'times_of_day' => json_encode(['07:25:00', '08:55:00', '10:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Pack Sabahyat 2 semaines',
            'price' => 12000,
            'spots_number' => 30,
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'times_of_day' => json_encode(['07:25:00', '08:55:00', '10:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Pack Weekend 1 WE',
            'price' => 3000,
            'spots_number' => 6,
            'days_of_week' => json_encode(['Saturday', 'Sunday']),
            'times_of_day' => json_encode(['14:25:00', '17:55:00', '19:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Pack Weekend 2 WE',
            'price' => 4800,
            'spots_number' => 12,
            'days_of_week' => json_encode(['Saturday', 'Sunday']),
            'times_of_day' => json_encode(['14:25:00', '17:55:00', '19:10:00']),
            'availability' => true,
        ]);
    }
}
