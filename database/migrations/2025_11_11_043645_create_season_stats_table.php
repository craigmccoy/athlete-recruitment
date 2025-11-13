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
        Schema::create('season_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_profile_id')->constrained()->onDelete('cascade');
            $table->integer('season_year');
            $table->integer('games_played')->default(0);
            $table->integer('receptions')->default(0);
            $table->integer('receiving_yards')->default(0);
            $table->decimal('yards_per_catch', 5, 2)->default(0);
            $table->integer('touchdowns')->default(0);
            $table->integer('rushing_yards')->nullable();
            $table->integer('tackles')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('season_stats');
    }
};
