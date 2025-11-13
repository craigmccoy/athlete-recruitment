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
        Schema::create('athlete_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('position');
            $table->string('jersey_number')->nullable();
            $table->integer('graduation_year');
            $table->string('school_name');
            $table->string('location')->nullable();
            $table->string('height')->nullable();
            $table->integer('weight')->nullable();
            $table->decimal('forty_time', 4, 2)->nullable();
            $table->decimal('gpa', 3, 2)->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->text('story')->nullable();
            $table->string('profile_image')->nullable();
            $table->json('social_links')->nullable();
            $table->json('skills')->nullable(); // For storing skill percentages
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('athlete_profiles');
    }
};
