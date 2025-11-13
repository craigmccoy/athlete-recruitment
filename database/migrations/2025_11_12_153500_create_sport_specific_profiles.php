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
        // Football-specific profile
        Schema::create('football_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_profile_id')->constrained()->onDelete('cascade');
            $table->string('position');
            $table->string('jersey_number')->nullable();
            $table->decimal('forty_yard_dash', 4, 2)->nullable();
            $table->decimal('bench_press', 5, 1)->nullable(); // lbs
            $table->decimal('squat', 5, 1)->nullable(); // lbs
            $table->decimal('vertical_jump', 4, 1)->nullable(); // inches
            $table->json('skills')->nullable(); // Route Running, Catching, etc.
            $table->timestamps();
        });

        // Basketball-specific profile
        Schema::create('basketball_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_profile_id')->constrained()->onDelete('cascade');
            $table->string('position');
            $table->string('jersey_number')->nullable();
            $table->decimal('vertical_jump', 4, 1)->nullable(); // inches
            $table->decimal('sprint_speed', 4, 2)->nullable(); // seconds
            $table->decimal('wingspan', 4, 1)->nullable(); // inches
            $table->json('skills')->nullable(); // Shooting, Ball Handling, etc.
            $table->timestamps();
        });

        // Baseball-specific profile
        Schema::create('baseball_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_profile_id')->constrained()->onDelete('cascade');
            $table->string('position');
            $table->string('jersey_number')->nullable();
            $table->decimal('sixty_yard_dash', 4, 2)->nullable();
            $table->decimal('exit_velocity', 5, 1)->nullable(); // mph
            $table->string('batting_stance')->nullable(); // Right, Left, Switch
            $table->string('throwing_hand')->nullable(); // Right, Left
            $table->json('skills')->nullable(); // Hitting, Fielding, Pitching, etc.
            $table->timestamps();
        });

        // Soccer-specific profile
        Schema::create('soccer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_profile_id')->constrained()->onDelete('cascade');
            $table->string('position');
            $table->string('jersey_number')->nullable();
            $table->decimal('sprint_speed', 4, 2)->nullable();
            $table->string('preferred_foot')->nullable(); // Right, Left, Both
            $table->json('skills')->nullable(); // Dribbling, Passing, Shooting, etc.
            $table->timestamps();
        });

        // Track & Field-specific profile
        Schema::create('track_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_profile_id')->constrained()->onDelete('cascade');
            $table->string('events')->nullable(); // 100m, 200m, Long Jump, etc.
            $table->json('personal_records')->nullable(); // PRs for each event
            $table->json('skills')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_profiles');
        Schema::dropIfExists('soccer_profiles');
        Schema::dropIfExists('baseball_profiles');
        Schema::dropIfExists('basketball_profiles');
        Schema::dropIfExists('football_profiles');
    }
};
