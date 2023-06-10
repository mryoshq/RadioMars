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
            $table->decimal('price', 8, 2);
            $table->integer('spots_number')->default(6);
            $table->json('days_of_week')->nullable();
            $table->json('times_of_day')->nullable(); 
            $table->boolean('availability')->default(1);
            $table->timestamps();
        });
    }
 
    public function down()
    {
        Schema::dropIfExists('packs');
    }
}
