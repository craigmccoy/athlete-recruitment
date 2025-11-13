<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add sport field to athlete profiles
        Schema::table('athlete_profiles', function (Blueprint $table) {
            $table->string('sport')->default('football')->after('position');
        });

        // Add sport field to season stats
        Schema::table('season_stats', function (Blueprint $table) {
            $table->string('sport')->default('football')->after('athlete_profile_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('athlete_profiles', function (Blueprint $table) {
            $table->dropColumn('sport');
        });

        Schema::table('season_stats', function (Blueprint $table) {
            $table->dropColumn('sport');
        });
    }
};
