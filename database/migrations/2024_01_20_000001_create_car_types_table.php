<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('car_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., Sedan, SUV
            $table->decimal('price_modifier', 8, 2)->default(1.00); // 1.0, 1.2, etc.
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('car_types');
    }
};
