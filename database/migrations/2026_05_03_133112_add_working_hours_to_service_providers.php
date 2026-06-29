<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_providers', function (Blueprint $table) {
            $table->time('open_time')->default('08:00:00')->after('service_radius_km');
            $table->time('close_time')->default('18:00:00')->after('open_time');
        });

        // Also add duration_minutes to bookings so we can do overlap checks
        Schema::table('bookings', function (Blueprint $table) {
            $table->unsignedInteger('duration_minutes')->default(60)->after('appointment_time');
        });
    }

    public function down(): void
    {
        Schema::table('service_providers', function (Blueprint $table) {
            $table->dropColumn(['open_time', 'close_time']);
        });
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('duration_minutes');
        });
    }
};
