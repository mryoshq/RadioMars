<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');

            $table->enum('payment_method', ['cc', 'transfer', 'wire'])->nullable();
            $table->enum('status', ['pending', 'paid', 'failed'])->nullable();

            $table->unsignedBigInteger('advertiser_id');  
            $table->unsignedBigInteger('ad_id')->nullable(); 

            $table->timestamps();
            $table->softDeletes(); 

            //foreign keys
            $table->foreign('ad_id')->references('id')->on('ads')->onDelete('set null');


        });
    } 
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
 