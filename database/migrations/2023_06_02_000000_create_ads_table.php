<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()  
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id(); 
          
            $table->string('text_content')->nullable();
            $table->string('audio_content')->nullable();
            $table->enum('status', ['active', 'not_active', 'paused'])->nullable();
            $table->integer('pack_variation')->nullable();

            $table->unsignedBigInteger('advertiser_id');
            $table->unsignedBigInteger('pack_id')->nullable();
            
            $table->timestamps();
            $table->softDeletes(); 
        
            // Foreign key constraints
            $table->foreign('advertiser_id')->references('id')->on('advertisers')->onDelete('cascade');
            $table->foreign('pack_id')->references('id')->on('packs')->onDelete('set null');
            
        });
        
    }

    /**  
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ads');
    }
}
