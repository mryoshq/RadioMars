<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Spot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
class SpotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Spot::factory()->count(500)->create();
    }
}
