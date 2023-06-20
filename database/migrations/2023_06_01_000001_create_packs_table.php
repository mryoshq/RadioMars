<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePacksTable extends Migration
{
    public function up()
    {
        Schema::create('packs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('price', 8, 2); // kept it decimal cuz maybe some packs would be 499.99 magic number like opinionated yet flexible :3
            $table->integer('period')->default(1); 
            $table->integer('spots_number')->default(6);
            $table->json('days_of_week');
            $table->json('times_of_day'); 
            $table->boolean('availability')->default(0);
            $table->timestamps();
        });
    }
    
 
    public function down()
    {
        Schema::dropIfExists('packs');
    }
}
