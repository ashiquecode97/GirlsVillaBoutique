<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('user_id');
        $table->string('name');
        $table->string('email');
        $table->text('address');
        $table->string('city');
        $table->string('pincode');
        $table->string('phone');
        $table->string('payment_method');
        $table->integer('total_amount');
        $table->string('status')->default('Pending'); // Pending, Processing, Delivered

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
