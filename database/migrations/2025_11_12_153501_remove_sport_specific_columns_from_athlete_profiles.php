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
        // Remove sport-specific columns from athlete_profiles
        Schema::table('athlete_profiles', function (Blueprint $table) {
            $table->dropColumn(['position', 'jersey_number', 'forty_time', 'skills']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add columns back
        Schema::table('athlete_profiles', function (Blueprint $table) {
            $table->string('position')->nullable();
            $table->string('jersey_number')->nullable();
            $table->decimal('forty_time', 4, 2)->nullable();
            $table->json('skills')->nullable();
        });
    }
};
