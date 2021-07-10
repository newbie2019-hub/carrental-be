<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_id')->constrained()->onDelete('cascade');
            $table->string('pickup_date');
            $table->string('dropoff_date');
            $table->string('with_driver');
            $table->string('status');
            $table->string('total_payment');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_type_id')->constrained()->onDelete('cascade');
            $table->text('additional_instructions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rentals');
    }
}
