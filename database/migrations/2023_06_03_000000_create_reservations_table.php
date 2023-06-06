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
            $table->unsignedBigInteger('user_id'); 
            $table->unsignedBigInteger('ad_id'); 
            $table->unsignedBigInteger('pack_id'); 
            $table->enum('status', ['pending', 'confirmed', 'cancelled']);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('ad_id')->references('id')->on('ads');
            $table->foreign('pack_id')->references('id')->on('packs');
        });
    } 

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
