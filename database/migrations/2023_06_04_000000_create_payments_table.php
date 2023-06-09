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
            $table->unsignedBigInteger('user_id');  
            $table->unsignedBigInteger('reservation_id')->nullable(); 
            $table->decimal('amount', 8, 2);
            $table->enum('payment_method', ['cc', 'transfer', 'wire']);
            $table->enum('status', ['pending', 'paid', 'failed']);
            $table->timestamps();

           
            $table->foreign('reservation_id')->references('id')->on('reservations')->onDelete('set null');


        });
    } 
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
