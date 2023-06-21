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
            'period' => ["1", "2"],
            'price' => ["10500", "17500"],
            'spots_number' => ["35", "70"],
            'days_of_week' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'times_of_day' => ['07:25:00', '10:25:00', '14:55:00', '17:25:00', '19:10:00'],
            'availability' => [true, true],
        ]);
    
        Pack::factory()->create([
            'name' => 'Sabahiyates',
            'description' => 'Ce pack vous permet de diffuser votre publicité du lundi au vendredi et spécialement durant les horaires matinales .',
            'period' => ["1", "2"],
            'price' => ["7500", "12000"],
            'spots_number' => ["15", "30"],
            'days_of_week' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'times_of_day' => ['07:25:00', '08:55:00', '10:10:00'],
            'availability' => [true, true],
        ]);
    
        Pack::factory()->create([
            'name' => 'Weekend',
            'description' => 'Ce pack vous permet de diffuser votre publicité pendant le weekend , 3 fois durant l\'après-midi.',
            'period' => ["1", "2"],
            'price' => ["3000", "4800"],
            'spots_number' => ["6", "12"],
            'days_of_week' => ['Saturday', 'Sunday'],
            'times_of_day' => ['14:25:00', '17:55:00', '19:10:00'],
            'availability' => [true, true],
        ]);
    
        Pack::factory()->create([
            'name' => 'Massayiates',
            'description' => 'Ce pack vous permet de diffuser votre publicité  du lundi au vendredi et spécialement durant les horaires du soir, durant  ces horaires 13h/15h/17h.',
            'period' => ["1", "2"],
            'price' => ["5000", "8000"],
            'spots_number' => ["15", "30"],
            'days_of_week' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
            'times_of_day' => ['13:00:00', '15:00:00', '17:00:00'], 
            'availability' => [true, true],
        ]);
    
        Pack::factory()->create([
            'name' => 'Ramadan',
            'description' => 'Ce pack est disponible que durant la période du Ramadan et vous permet de diffuser votre publicité durant les journées de ramadan.',
            'period' => ["1", "2"],
            'price' => ["6000", "10000"],
            'spots_number' => ["20", "40"],
            'days_of_week' => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            'times_of_day' => ['12:00:00', '15:00:00', '18:00:00', '21:00:00'], 
            'availability' => [true, true],
        ]);
    }
    
}
