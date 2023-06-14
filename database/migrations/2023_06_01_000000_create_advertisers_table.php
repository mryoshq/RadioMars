<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdvertisersTable extends Migration
{ 
    /** 
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('advertisers', function (Blueprint $table) {
            $table->id();
            
            $table->string('firm', 40);
            $table->enum('domain', ['artisanal1', 'artisanal2', 'artisanal3', 'artisanal4', 'artisanal5', 'artisanal6', 'artisanal7', 'artisanal8', 'artisanal9', 'artisanal10']);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /** 
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advertisers');
    }
};
