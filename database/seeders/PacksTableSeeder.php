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
            'name' => 'Classique',
            'description' => "Ce pack vous permet de diffuser votre publicité du Lundi au Dimanche durant une semaine ou deux suivant votre choix. L'avantage de ce pack sont ses horaires, étant celle où l'audience est la plus élevée",
            'period' => 1,
            'price' => 10500,
            'spots_number' => 35,
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'times_of_day' => json_encode(['07:25:00', '10:25:00', '14:55:00', '17:25:00', '19:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Classique',
            'description' => "Ce pack vous permet de diffuser votre publicité du Lundi au Dimanche durant deux semaines. L'avantage de ce pack sont ses horaires, étant celle où l'audience est la plus élevée. Profitez d'une réduction en choissisant cette variante de deux semaines et de plus d'impact sur votre public",
            'period' => 2,
            'price' => 17500,
            'spots_number' => 70,
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'times_of_day' => json_encode(['07:25:00', '10:25:00', '14:55:00', '17:25:00', '19:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Sabahiyates',
            'description' => 'Ce pack vous permet de diffuser votre publicité du lundi au vendredi et spécialement durant les horaires matinales .',
            'period' => 1,
            'price' => 7500,
            'spots_number' => 15,
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'times_of_day' => json_encode(['07:25:00', '08:55:00', '10:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Sabahiyates',
            'description' => 'Ce pack vous permet de diffuser votre publicité du lundi au vendredi pendant deux semaines et spécialement durant les horaires matinales .',
            'period' => 2,
            'price' => 12000,
            'spots_number' => 30,
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'times_of_day' => json_encode(['07:25:00', '08:55:00', '10:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Weekend',
            'description' => 'Ce pack vous permet de diffuser votre publicité pendant le weekend , 3 fois durant l\'après-midi.',
            'period' => 1,
            'price' => 3000,
            'spots_number' => 6,
            'days_of_week' => json_encode(['Saturday', 'Sunday']),
            'times_of_day' => json_encode(['14:25:00', '17:55:00', '19:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Weekend',
            'description' => 'Ce pack vous permet de diffuser votre publicité pendant le weekend pour deux semaines, 3 fois durant l\'après-midi.',
            'period' => 2,
            'price' => 4800,
            'spots_number' => 12,
            'days_of_week' => json_encode(['Saturday', 'Sunday']),
            'times_of_day' => json_encode(['14:25:00', '17:55:00', '19:10:00']),
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Massayiates',
            'description' => 'Ce pack vous permet de diffuser votre publicité  du lundi au vendredi et spécialement durant les horaires du soir, durant  ces horaires 13h/15h/17h.',
            'period' => 1,
            'price' => 5000, 
            'spots_number' => 15, 
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'times_of_day' => json_encode(['13:00:00', '15:00:00', '17:00:00']), 
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Massayiates',
            'description' => 'Ce pack vous permet de diffuser votre publicité  du lundi au vendredi pendant deux semaines et spécialement durant les horaires du soir, durant  ces horaires 13h/15h/17h.',
            'period' => 2,
            'price' => 8000,
            'spots_number' => 30,
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'times_of_day' => json_encode(['13:00:00', '15:00:00', '17:00:00']), 
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Ramadan 1',
            'description' => 'Ce pack est disponible que durant la période du Ramadan et vous permet de diffuser votre publicité durant les journées de ramadan.',
            'period' => 1,
            'price' => 6000, 
            'spots_number' => 20, 
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'times_of_day' => json_encode(['12:00:00', '15:00:00', '18:00:00', '21:00:00']), 
            'availability' => true,
        ]);

        Pack::factory()->create([
            'name' => 'Ramadan',
            'description' => 'Ce pack est disponible que durant la période du Ramadan pour deux semaines et vous permet de diffuser votre publicité durant les journées de ramadan.',
            'period' => 2,
            'price' => 10000, 
            'spots_number' => 40, 
            'days_of_week' => json_encode(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'times_of_day' => json_encode(['12:00:00', '15:00:00', '18:00:00', '21:00:00']), 
            'availability' => true,
        ]);
    }
}
