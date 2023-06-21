<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Pack;

class CreatePacksTable extends Migration
{
    public function up()
    {
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
           
            $table->json('period');
            $table->json('price');
            $table->json('spots_number');
            $table->json('days_of_week');
            $table->json('times_of_day'); 
            $table->json('availability'); 
            $table->timestamps();
        });
    }
    
  
    public function down()
    {
        Schema::dropIfExists('packs');
    }
}
