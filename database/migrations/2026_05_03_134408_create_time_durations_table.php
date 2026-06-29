<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_durations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('minutes')->unique();
            $table->string('label');          // e.g. "30 Minutes", "1 Hour 30 Minutes"
            $table->timestamps();
        });

        // Seed default durations
        DB::table('time_durations')->insert([
            ['minutes' => 15,  'label' => '15 Minutes',          'created_at' => now(), 'updated_at' => now()],
            ['minutes' => 30,  'label' => '30 Minutes',          'created_at' => now(), 'updated_at' => now()],
            ['minutes' => 45,  'label' => '45 Minutes',          'created_at' => now(), 'updated_at' => now()],
            ['minutes' => 60,  'label' => '1 Hour',              'created_at' => now(), 'updated_at' => now()],
            ['minutes' => 90,  'label' => '1 Hour 30 Minutes',   'created_at' => now(), 'updated_at' => now()],
            ['minutes' => 120, 'label' => '2 Hours',             'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('time_durations');
    }
};
