<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_brand_id')->constrained()->onDelete('cascade');
            $table->string('model');
            $table->string('status')->default('available');
            $table->text('description');
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->foreignId('transmission_type_id')->constrained()->onDelete('cascade');
            $table->string('image');
            $table->string('year');
            $table->integer('seats');
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
        Schema::dropIfExists('cars');
    }
}
