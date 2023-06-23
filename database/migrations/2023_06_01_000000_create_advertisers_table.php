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
            $table->enum('domain', ['Céramique', 'Maroquinerie', 'Tapisserie', 'Bijouterie', 'Boiserie', 'Métallurgie', 'Textile', 'Vannerie', 'Broderie', 'Poterie']);
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
