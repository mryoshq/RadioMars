<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id'); 
            $table->enum('status', ['pending', 'confirmed', 'cancelled']);
            $table->timestamps();

        
           
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('cascade');

        });
    } 

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
