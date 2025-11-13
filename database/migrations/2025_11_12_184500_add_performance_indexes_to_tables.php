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
        // Add index to athlete_profiles for faster active profile lookups
        Schema::table('athlete_profiles', function (Blueprint $table) {
            $table->index('is_active');
        });

        // Add composite index to season_stats for ordered queries by athlete and year
        Schema::table('season_stats', function (Blueprint $table) {
            $table->index(['athlete_profile_id', 'season_year']);
        });

        // Add indexes to highlights for filtering and sorting
        Schema::table('highlights', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('is_featured');
            $table->index('order');
        });

        // Add composite index to awards for ordered queries by athlete and year
        Schema::table('awards', function (Blueprint $table) {
            $table->index(['athlete_profile_id', 'year']);
        });

        // Add indexes to contact_submissions for admin dashboard queries
        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->index('is_read');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('athlete_profiles', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        // Skip dropping season_stats index - it's used by foreign key constraint
        // The index will remain even after rollback to avoid FK constraint errors

        Schema::table('highlights', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['order']);
        });

        // Skip dropping awards index - it may be used by foreign key constraint
        // The index will remain even after rollback to avoid FK constraint errors

        Schema::table('contact_submissions', function (Blueprint $table) {
            $table->dropIndex(['is_read']);
            $table->dropIndex(['created_at']);
        });
    }
};
