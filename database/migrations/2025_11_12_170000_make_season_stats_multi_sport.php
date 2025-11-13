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
        Schema::table('season_stats', function (Blueprint $table) {
            // Drop old football-specific columns
            $table->dropColumn([
                'receptions',
                'receiving_yards',
                'yards_per_catch',
                'touchdowns',
                'rushing_yards',
                'tackles'
            ]);
            
            // Rename games_played to competitions (more generic)
            $table->renameColumn('games_played', 'competitions');
            
            // Add JSON column for sport-specific stats
            $table->json('stats')->nullable()->after('competitions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('season_stats', function (Blueprint $table) {
            $table->dropColumn('stats');
            
            // Rename back to games_played
            $table->renameColumn('competitions', 'games_played');
            
            // Re-add old columns
            $table->integer('receptions')->default(0);
            $table->integer('receiving_yards')->default(0);
            $table->decimal('yards_per_catch', 5, 2)->default(0);
            $table->integer('touchdowns')->default(0);
            $table->integer('rushing_yards')->nullable();
            $table->integer('tackles')->nullable();
        });
    }
};
