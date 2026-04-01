<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('car_models', function (Blueprint $table) {
            $table->id();
            $table->foreignId('car_type_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., Toyota Corolla, Honda Civic
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_models');
    }
};
