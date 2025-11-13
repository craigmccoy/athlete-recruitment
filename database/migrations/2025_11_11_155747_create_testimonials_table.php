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
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('athlete_profile_id')->constrained()->onDelete('cascade');
            $table->string('author_name');
            $table->string('author_title')->nullable(); // e.g., "Head Coach", "Athletic Director"
            $table->string('author_organization')->nullable(); // e.g., "Lincoln High School"
            $table->text('content');
            $table->string('relationship')->nullable(); // e.g., "Coach", "Teammate", "Teacher"
            $table->date('date')->nullable();
            $table->string('author_image')->nullable();
            $table->integer('rating')->nullable(); // 1-5 stars (optional)
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();

            // Indexes
            $table->index(['athlete_profile_id', 'is_active', 'order']);
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
