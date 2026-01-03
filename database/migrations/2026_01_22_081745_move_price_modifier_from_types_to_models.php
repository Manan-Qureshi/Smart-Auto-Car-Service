<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('car_types', function (Blueprint $table) {
            $table->dropColumn('price_modifier');
        });

        Schema::table('car_models', function (Blueprint $table) {
            $table->decimal('price_modifier', 8, 2)->default(1.0)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('car_models', function (Blueprint $table) {
            $table->dropColumn('price_modifier');
        });

        Schema::table('car_types', function (Blueprint $table) {
            $table->decimal('price_modifier', 8, 2)->default(1.0);
        });
    }
};
